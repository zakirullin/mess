<?php
declare(strict_types=1);

namespace Zakirullin\Mess;

use Zakirullin\Mess\Enum\TypeEnum;
use Zakirullin\Mess\Exception\CannotModifyMessException;
use Zakirullin\Mess\Exception\UncastableValueException;
use Zakirullin\Mess\Exception\UnexpectedKeyTypeException;
use Zakirullin\Mess\Exception\UnexpectedTypeException;
use function is_array;
use function is_bool;
use function is_int;
use function is_object;
use function is_string;
use function key_exists;
use function property_exists;

/**
 * @psalm-immutable
 */
class Mess implements MessInterface
{
    /**
     * @var mixed
     */
    private $value;

    /**
     * @psalm-allow-private-mutation
     * @psalm-var list<string|int>
     *
     * @var array
     */
    private $keySequence = [];

    /**
     *
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @psalm-mutation-free
     *
     * @return int
     */
    public function getInt(): int
    {
        $this->assertType(is_int($this->value), TypeEnum::INT);

        /**
         * @var int
         */
        return $this->value;
    }

    /**
     * @psalm-mutation-free
     *
     * @return bool
     */
    public function getBool(): bool
    {
        $this->assertType(is_bool($this->value), TypeEnum::BOOL);

        /**
         * @var bool
         */
        return $this->value;
    }

    /**
     * @psalm-mutation-free
     *
     * @return string
     */
    public function getString(): string
    {
        $this->assertType(is_string($this->value), TypeEnum::STRING);

        /**
         * @var string
         */
        return $this->value;
    }

    /**
     * @psalm-mutation-free
     * @psalm-return list<int>
     *
     * @return array
     */
    public function getListOfInt(): array
    {
        $this->assertType(isListOfType($this->value, 'is_int'), TypeEnum::LIST_OF_INT);

        /**
         * @psalm-var list<int>
         */
        return $this->value;
    }

    /**
     * @psalm-mutation-free
     * @psalm-return list<string>
     *
     * @return array
     */
    public function getListOfString(): array
    {
        $this->assertType(isListOfType($this->value, 'is_string'), TypeEnum::LIST_OF_STRING);

        /**
         * @psalm-var list<string>
         */
        return $this->value;
    }

    /**
     * @psalm-mutation-free
     * @psalm-return array<string,int>
     *
     * @return array
     */
    public function getArrayOfStringToInt(): array
    {
        $this->assertType(isArrayOfStringToType($this->value, 'is_int'), TypeEnum::ARRAY_OF_STRING_TO_INT);

        /**
         * @psalm-var array<string,int>
         */
        return $this->value;
    }

    /**
     * @psalm-mutation-free
     * @psalm-return array<string,bool>
     *
     * @return array
     */
    public function getArrayOfStringToBool(): array
    {
        $this->assertType(
            isArrayOfStringToType($this->value, 'is_bool'),
            TypeEnum::ARRAY_OF_STRING_TO_BOOL
        );

        /**
         * @var array<string,bool>
         */
        return $this->value;
    }

    /**
     * @psalm-mutation-free
     * @psalm-return array<string,string>
     *
     * @return array
     */
    public function getArrayOfStringToString(): array
    {
        $this->assertType(
            isArrayOfStringToType($this->value, 'is_string'),
            TypeEnum::ARRAY_OF_STRING_TO_STRING
        );

        /**
         * @psalm-var array<string,string>
         */
        return $this->value;
    }

    /**
     * @psalm-mutation-free
     *
     * @return int
     */
    public function getAsInt(): int
    {
        $int = toInt($this->value);

        $this->assertCastable($int !== null, TypeEnum::INT);

        /**
         * @var int
         */
        return $int;
    }

    /**
     * @psalm-mutation-free
     *
     * @return bool
     */
    public function getAsBool(): bool
    {
        $bool = toBool($this->value);

        $this->assertCastable($bool !== null, TypeEnum::BOOL);

        return $bool;
    }

    /**
     * @psalm-mutation-free
     *
     * @return string
     */
    public function getAsString(): string
    {
        $string = toString($this->value);

        $this->assertCastable($string !== null, TypeEnum::STRING);

        return $string;
    }

    /**
     * @psalm-mutation-free
     * @psalm-return list<int>
     *
     * @return array
     */
    public function getAsListOfInt(): array
    {
        /**
         * @psalm-var list<int>|null
         */
        $listOfInt = toListOfType($this->value, '\Zakirullin\Mess\toInt');

        $this->assertCastable($listOfInt !== null, TypeEnum::LIST_OF_INT);

        return $listOfInt;
    }

    /**
     * @psalm-mutation-free
     * @psalm-return list<string>
     *
     * @return array
     */
    public function getAsListOfString(): array
    {
        /**
         * @psalm-var list<string>|null
         */
        $listOfString = toListOfType($this->value, '\Zakirullin\Mess\toString');

        $this->assertCastable($listOfString !== null, TypeEnum::LIST_OF_STRING);

        return $listOfString;
    }

    /**
     * @psalm-mutation-free
     * @psalm-return array<string,int>
     *
     * @return array
     */
    public function getAsArrayOfStringToInt(): array
    {
        /**
         * @psalm-var array<string,int>|null
         */
        $arrayOfStringToInt = toArrayOfStringToType($this->value, '\Zakirullin\Mess\toInt');

        $this->assertCastable($arrayOfStringToInt !== null, TypeEnum::ARRAY_OF_STRING_TO_INT);

        return $arrayOfStringToInt;
    }

    /**
     * @psalm-mutation-free
     * @psalm-return array<string,bool>
     *
     * @return array
     */
    public function getAsArrayOfStringToBool(): array
    {
        /**
         * @psalm-var array<string,bool>|null
         */
        $arrayOfStringToBool = toArrayOfStringToType($this->value, '\Zakirullin\Mess\toBool');

        $this->assertCastable($arrayOfStringToBool !== null, TypeEnum::ARRAY_OF_STRING_TO_BOOL);

        return $arrayOfStringToBool;
    }

    /**
     * @psalm-mutation-free
     * @psalm-return array<string,string>
     *
     * @return array
     */
    public function getAsArrayOfStringToString(): array
    {
        /**
         * @psalm-var array<string,string>|null
         */
        $arrayOfStringToString = toArrayOfStringToType($this->value, '\Zakirullin\Mess\toString');

        $this->assertCastable($arrayOfStringToString !== null, TypeEnum::ARRAY_OF_STRING_TO_STRING);

        return $arrayOfStringToString;
    }

    /**
     * @psalm-mutation-free
     *
     * @return int|null
     */
    public function findInt(): ?int
    {
        if ($this->value === null) {
            return null;
        }

        return $this->getInt();
    }

    /**
     * @psalm-mutation-free
     *
     * @return bool|null
     */
    public function findBool(): ?bool
    {
        if ($this->value === null) {
            return null;
        }

        return $this->getBool();
    }

    /**
     * @psalm-mutation-free
     *
     * @return string|null
     */
    public function findString(): ?string
    {
        if ($this->value === null) {
            return null;
        }

        return $this->getString();
    }

    /**
     * @psalm-mutation-free
     * @psalm-return list<int>|null
     *
     * @return array|null
     */
    public function findListOfInt(): ?array
    {
        if ($this->value === null) {
            return null;
        }

        return $this->getListOfInt();
    }

    /**
     * @psalm-mutation-free
     * @psalm-return list<string>|null
     *
     * @return array|null
     */
    public function findListOfString(): ?array
    {
        if ($this->value === null) {
            return null;
        }

        return $this->getListOfString();
    }

    /**
     * @psalm-mutation-free
     * @psalm-return array<string,int>|null
     *
     * @return array|null
     */
    public function findArrayOfStringToInt(): ?array
    {
        if ($this->value === null) {
            return null;
        }

        return $this->getArrayOfStringToInt();
    }

    /**
     * @psalm-mutation-free
     * @psalm-return array<string,bool>|null
     *
     * @return array|null
     */
    public function findArrayOfStringToBool(): ?array
    {
        if ($this->value === null) {
            return null;
        }

        return $this->getArrayOfStringToBool();
    }

    /**
     * @psalm-mutation-free
     * @psalm-return array<string,string>|null
     *
     * @return array|null
     */
    public function findArrayOfStringToString(): ?array
    {
        if ($this->value === null) {
            return null;
        }

        return $this->getArrayOfStringToString();
    }

    /**
     * @psalm-mutation-free
     *
     * @return int|null
     */
    public function findAsInt(): ?int
    {
        if ($this->value === null) {
            return null;
        }

        return $this->getAsInt();
    }

    /**
     * @psalm-mutation-free
     *
     * @return bool|null
     */
    public function findAsBool(): ?bool
    {
        if ($this->value === null) {
            return null;
        }

        return $this->getAsBool();
    }

    /**
     * @psalm-mutation-free
     *
     * @return string|null
     */
    public function findAsString(): ?string
    {
        if ($this->value === null) {
            return null;
        }

        return $this->getAsString();
    }

    /**
     * @psalm-return list<int>|null
     *
     * @return array|null
     */
    public function findAsListOfInt(): ?array
    {
        if ($this->value === null) {
            return null;
        }

        return $this->getAsListOfInt();
    }

    /**
     * @psalm-return list<string>|null
     *
     * @return array|null
     */
    public function findAsListOfString(): ?array
    {
        if ($this->value === null) {
            return null;
        }

        return $this->getAsListOfString();
    }

    /**
     * @psalm-mutation-free
     * @psalm-return array<string,int>|null
     *
     * @return array|null
     */
    public function findAsArrayOfStringToInt(): ?array
    {
        if ($this->value === null) {
            return null;
        }

        return $this->getAsArrayOfStringToInt();
    }

    /**
     * @psalm-mutation-free
     * @psalm-return array<string,bool>|null
     *
     * @return array|null
     */
    public function findAsArrayOfStringToBool(): ?array
    {
        if ($this->value === null) {
            return null;
        }

        return $this->getAsArrayOfStringToBool();
    }

    /**
     * @psalm-mutation-free
     * @psalm-return array<string,string>|null
     *
     * @return array|null
     */
    public function findAsArrayOfStringToString(): ?array
    {
        if ($this->value === null) {
            return null;
        }

        return $this->getAsArrayOfStringToString();
    }

    /**
     * @psalm-mutation-free
     *
     * @return mixed
     */
    public function getMixed()
    {
        return $this->value;
    }

    /**
     * @return object
     */
    public function getObject(): object
    {
        $this->assertType(is_object($this->value), TypeEnum::OBJECT);

        /**
         * @var object
         */
        return $this->value;
    }

    /**
     * @return array
     */
    public function getArray(): array
    {
        $this->assertType(is_array($this->value), TypeEnum::ARRAY);

        /**
         * @var array
         */
        return $this->value;
    }

    /**
     * @psalm-mutation-free
     * @psalm-return array<string,mixed>
     *
     * @return array
     */
    public function getArrayOfStringToMixed(): array
    {
        $this->assertType(isArrayOfStringToMixed($this->value), TypeEnum::ARRAY_OF_STRING_TO_MIXED);

        /**
         * @psalm-var array<string,mixed>
         */
        return $this->value;
    }

    /**
     * @psalm-mutation-free
     *
     * @return mixed
     */
    public function findMixed()
    {
        return $this->value;
    }

    /**
     * @return object|null
     */
    public function findObject(): ?object
    {
        if ($this->value === null) {
            return null;
        }

        return $this->getObject();
    }

    /**
     * @return array|null
     */
    public function findArray(): ?array
    {
        if ($this->value === null) {
            return null;
        }

        return $this->getArray();
    }

    /**
     * @psalm-mutation-free
     * @psalm-return array<string,mixed>|null
     *
     * @return array|null
     */
    public function findArrayOfStringToMixed(): ?array
    {
        if ($this->value === null) {
            return null;
        }

        return $this->getArrayOfStringToMixed();
    }

    /**
     * @psalm-mutation-free
     *
     * @param string|int $offset
     * @return MessInterface
     */
    public function offsetGet($offset)
    {
        /**
         * @psalm-suppress DocblockTypeContradiction
         */
        if (!is_string($offset) && !is_int($offset)) {
            throw new UnexpectedKeyTypeException($offset, $this->keySequence);
        }

        $clonedKeySequence = $this->keySequence;
        $clonedKeySequence[] = $offset;

        if (!$this->offsetExists($offset)) {
            return new MissingMess($clonedKeySequence);
        }

        return (new self($this->getByOffset($offset)))->setKeySequence($clonedKeySequence);
    }

    /**
     * @psalm-mutation-free
     *
     * @param string|int $offset
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        if (is_array($this->value)) {
            return key_exists($offset, $this->value);
        }

        if (is_object($this->value) && is_string($offset)) {
            return property_exists($this->value, $offset);
        }

        return false;
    }

    /**
     * @psalm-mutation-free
     *
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value): void
    {
        throw new CannotModifyMessException($this->keySequence);
    }

    /**
     * @psalm-mutation-free
     *
     * @param mixed $offset
     */
    public function offsetUnset($offset): void
    {
        throw new CannotModifyMessException($this->keySequence);
    }

    /**
     * @psalm-external-mutation-free
     * @psalm-param list<string|int> $keySequence
     *
     * @param array $keySequence
     * @return Mess
     */
    private function setKeySequence(array $keySequence): self
    {
        $this->keySequence = $keySequence;

        return $this;
    }

    /**
     * @param bool   $isExpected
     * @param string $expectedType
     */
    private function assertType(bool $isExpected, string $expectedType): void
    {
        if (!$isExpected) {
            throw new UnexpectedTypeException($expectedType, $this->value, $this->keySequence);
        }
    }

    /**
     * @param bool   $isCastable
     * @param string $desiredType
     */
    private function assertCastable(bool $isCastable, string $desiredType): void
    {
        if (!$isCastable) {
            throw new UncastableValueException($desiredType, $this->value, $this->keySequence);
        }
    }

    /**
     * @param string|int $offset
     * @return mixed
     */
    private function getByOffset($offset)
    {
        /**
         * @var object|array $this ->value
         */
        if (is_object($this->value) && is_string($offset)) {
            return $this->value->$offset;
        }

        /**
         * @var array $this->value
         */
        return $this->value[$offset];
    }
}