<?php
declare(strict_types=1);

namespace Zakirullin\Mess;

use Zakirullin\Mess\Caster\ArrayOfStringToTypeCaster;
use Zakirullin\Mess\Caster\BoolCaster;
use Zakirullin\Mess\Caster\IntCaster;
use Zakirullin\Mess\Caster\ListOfTypeCaster;
use Zakirullin\Mess\Caster\StringCaster;
use Zakirullin\Mess\Enum\TypeEnum;
use Zakirullin\Mess\Exception\CannotModifyMessException;
use Zakirullin\Mess\Exception\UncastableValueException;
use Zakirullin\Mess\Exception\UnexpectedKeyTypeException;
use Zakirullin\Mess\Exception\UnexpectedTypeException;
use Zakirullin\Mess\Finder\ArrayOfStringToMixedFinder;
use Zakirullin\Mess\Finder\ArrayOfStringToTypeFinder;
use Zakirullin\Mess\Finder\ListOfTypeFinder;
use function is_array;
use function is_bool;
use function is_int;
use function is_object;
use function is_string;
use function key_exists;

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
     * @psalm-pure
     *
     * @return int
     */
    public function getInt(): int
    {
        $this->assertType($this->findInt(), TypeEnum::INT);

        /**
         * @var int
         */
        return $this->value;
    }

    /**
     * @psalm-pure
     *
     * @return bool
     */
    public function getBool(): bool
    {
        $this->assertType($this->findBool(), TypeEnum::BOOL);

        /**
         * @var bool
         */
        return $this->value;
    }

    /**
     * @psalm-pure
     *
     * @return string
     */
    public function getString(): string
    {
        $this->assertType($this->findString(), TypeEnum::STRING);

        /**
         * @var string
         */
        return $this->value;
    }

    /**
     * @psalm-pure
     * @psalm-return list<int>
     *
     * @return array
     */
    public function getListOfInt(): array
    {
        $this->assertType($this->findListOfInt(), TypeEnum::LIST_OF_INT);

        /**
         * @psalm-var list<int>
         */
        return $this->value;
    }

    /**
     * @psalm-pure
     * @psalm-return list<string>
     *
     * @return array
     */
    public function getListOfString(): array
    {
        $this->assertType($this->findListOfString(), TypeEnum::LIST_OF_STRING);

        /**
         * @psalm-var list<string>
         */
        return $this->value;
    }

    /**
     * @psalm-pure
     * @psalm-return array<string,int>
     *
     * @return array
     */
    public function getArrayOfStringToInt(): array
    {
        $this->assertType($this->findArrayOfStringToInt(), TypeEnum::ARRAY_OF_STRING_TO_INT);

        /**
         * @psalm-var array<string,int>
         */
        return $this->value;
    }

    /**
     * @psalm-pure
     * @psalm-return array<string,bool>
     *
     * @return array
     */
    public function getArrayOfStringToBool(): array
    {
        $this->assertType($this->findArrayOfStringToBool(), TypeEnum::ARRAY_OF_STRING_TO_BOOL);

        /**
         * @var array<string,bool>
         */
        return $this->value;
    }

    /**
     * @psalm-pure
     * @psalm-return array<string,string>
     *
     * @return array
     */
    public function getArrayOfStringToString(): array
    {
        $this->assertType($this->findArrayOfStringToString(), TypeEnum::ARRAY_OF_STRING_TO_STRING);

        /**
         * @psalm-var array<string,string>
         */
        return $this->value;
    }

    /**
     * @psalm-pure
     *
     * @return int
     */
    public function getAsInt(): int
    {
        $intValue = $this->findAsInt();

        $this->assertCastable($intValue, TypeEnum::INT);

        /**
         * @var int
         */
        return $intValue;
    }

    /**
     * @psalm-pure
     *
     * @return bool
     */
    public function getAsBool(): bool
    {
        $boolValue = $this->findAsBool();

        $this->assertCastable($boolValue, TypeEnum::BOOL);

        return $boolValue;
    }

    /**
     * @psalm-pure
     *
     * @return string
     */
    public function getAsString(): string
    {
        $stringValue = $this->findAsString();

        $this->assertCastable($stringValue, TypeEnum::STRING);

        return $stringValue;
    }

    /**
     * @psalm-pure
     * @psalm-return list<int>
     *
     * @return array
     */
    public function getAsListOfInt(): array
    {
        $listOfInt = $this->findAsListOfInt();

        $this->assertCastable($listOfInt, TypeEnum::LIST_OF_INT);

        return $listOfInt;
    }

    /**
     * @psalm-pure
     * @psalm-return list<string>
     *
     * @return array
     */
    public function getAsListOfString(): array
    {
        $listOfString = $this->findAsListOfString();

        $this->assertCastable($listOfString, TypeEnum::LIST_OF_STRING);

        return $listOfString;
    }

    /**
     * @psalm-pure
     * @psalm-return array<string,int>
     *
     * @return array
     */
    public function getAsArrayOfStringToInt(): array
    {
        $arrayOfStringToInt = $this->findAsArrayOfStringToInt();

        $this->assertCastable($arrayOfStringToInt, TypeEnum::ARRAY_OF_STRING_TO_INT);

        return $arrayOfStringToInt;
    }

    /**
     * @psalm-pure
     * @psalm-return array<string,bool>
     *
     * @return array
     */
    public function getAsArrayOfStringToBool(): array
    {
        $arrayOfStringToBool = $this->findAsArrayOfStringToBool();

        $this->assertCastable($arrayOfStringToBool, TypeEnum::ARRAY_OF_STRING_TO_BOOL);

        return $arrayOfStringToBool;
    }

    /**
     * @psalm-pure
     * @psalm-return array<string,string>
     *
     * @return array
     */
    public function getAsArrayOfStringToString(): array
    {
        $arrayOfStringToString = $this->findAsArrayOfStringToString();

        $this->assertCastable($arrayOfStringToString, TypeEnum::ARRAY_OF_STRING_TO_STRING);

        return $arrayOfStringToString;
    }

    /**
     * @psalm-pure
     *
     * @return int|null
     */
    public function findInt(): ?int
    {
        if (!is_int($this->value)) {
            return null;
        }

        return $this->value;
    }

    /**
     * @psalm-pure
     *
     * @return bool|null
     */
    public function findBool(): ?bool
    {
        if (!is_bool($this->value)) {
            return null;
        }

        return $this->value;
    }

    /**
     * @psalm-pure
     *
     * @return string|null
     */
    public function findString(): ?string
    {
        if (!is_string($this->value)) {
            return null;
        }

        return $this->value;
    }

    /**
     * @psalm-pure
     * @psalm-return list<int>|null
     *
     * @return array|null
     */
    public function findListOfInt(): ?array
    {
        /**
         * @psalm-var list<int>|null
         */
        return ListOfTypeFinder::find($this->value, 'is_int');
    }

    /**
     * @psalm-pure
     * @psalm-return list<string>|null
     *
     * @return array|null
     */
    public function findListOfString(): ?array
    {
        /**
         * @psalm-var list<string>|null
         */
        return ListOfTypeFinder::find($this->value, 'is_string');
    }

    /**
     * @psalm-pure
     * @psalm-return array<string,int>|null
     *
     * @return array|null
     */
    public function findArrayOfStringToInt(): ?array
    {
        /**
         * @psalm-var array<string,int>|null
         */
        return ArrayOfStringToTypeFinder::find($this->value, 'is_int');
    }

    /**
     * @psalm-pure
     * @psalm-return array<string,bool>|null
     *
     * @return array|null
     */
    public function findArrayOfStringToBool(): ?array
    {
        /**
         * @psalm-var array<string,bool>|null
         */
        return ArrayOfStringToTypeFinder::find($this->value, 'is_bool');
    }

    /**
     * @psalm-pure
     * @psalm-return array<string,string>|null
     *
     * @return array|null
     */
    public function findArrayOfStringToString(): ?array
    {
        /**
         * @psalm-var array<string,string>|null
         */
        return ArrayOfStringToTypeFinder::find($this->value, 'is_string');
    }

    /**
     * @psalm-pure
     *
     * @return int|null
     */
    public function findAsInt(): ?int
    {
        return IntCaster::cast($this->value);
    }

    /**
     * @psalm-pure
     *
     * @return bool|null
     */
    public function findAsBool(): ?bool
    {
        return BoolCaster::cast($this->value);
    }

    /**
     * @psalm-pure
     *
     * @return string|null
     */
    public function findAsString(): ?string
    {
        return StringCaster::cast($this->value);
    }

    /**
     * @psalm-return list<int>|null
     *
     * @return array|null
     */
    public function findAsListOfInt(): ?array
    {
        /**
         * @psalm-var list<int>|null
         */
        return ListOfTypeCaster::cast($this->value, [IntCaster::class, 'cast']);
    }

    /**
     * @psalm-return list<string>|null
     *
     * @return array|null
     */
    public function findAsListOfString(): ?array
    {
        /**
         * @psalm-var list<string>|null
         */
        return ListOfTypeCaster::cast($this->value, [StringCaster::class, 'cast']);
    }

    /**
     * @psalm-pure
     * @psalm-return array<string,int>|null
     *
     * @return array|null
     */
    public function findAsArrayOfStringToInt(): ?array
    {
        /**
         * @psalm-var array<string,int>|null
         */
        return ArrayOfStringToTypeCaster::cast($this->value, [IntCaster::class, 'cast']);
    }

    /**
     * @psalm-pure
     * @psalm-return array<string,bool>|null
     *
     * @return array|null
     */
    public function findAsArrayOfStringToBool(): ?array
    {
        /**
         * @psalm-var array<string,bool>|null
         */
        return ArrayOfStringToTypeCaster::cast($this->value, [BoolCaster::class, 'cast']);
    }

    /**
     * @psalm-pure
     * @psalm-return array<string,string>|null
     *
     * @return array|null
     */
    public function findAsArrayOfStringToString(): ?array
    {
        /**
         * @psalm-var array<string,string>|null
         */
        return ArrayOfStringToTypeCaster::cast($this->value, [StringCaster::class, 'cast']);
    }

    /**
     * @psalm-pure
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
        $this->assertType($this->findObject(), TypeEnum::OBJECT);

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
        $this->assertType($this->findArray(), TypeEnum::ARRAY);

        /**
         * @var array
         */
        return $this->value;
    }

    /**
     * @psalm-pure
     * @psalm-return array<string,mixed>
     *
     * @return array
     */
    public function getArrayOfStringToMixed(): array
    {
        $this->assertType($this->findArrayOfStringToMixed(), TypeEnum::ARRAY_OF_STRING_TO_MIXED);

        /**
         * @psalm-var array<string,mixed>
         */
        return $this->value;
    }

    /**
     * @psalm-pure
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
        if (!is_object($this->value)) {
            return null;
        }

        return $this->value;
    }

    /**
     * @return array|null
     */
    public function findArray(): ?array
    {
        if (!is_array($this->value)) {
            return null;
        }

        return $this->value;
    }

    /**
     * @psalm-pure
     * @psalm-return array<string,mixed>|null
     *
     * @return array|null
     */
    public function findArrayOfStringToMixed(): ?array
    {
        /**
         * @psalm-var array<string,string>|null
         */
        return ArrayOfStringToMixedFinder::find($this->value);
    }

    /**
     * @psalm-pure
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

        /**
         * @var array
         */
        $array = $this->value;

        return (new self($array[$offset]))->setKeySequence($clonedKeySequence);
    }

    /**
     * @psalm-pure
     *
     * @param string|int $offset
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        if (!is_array($this->value)) {
            return false;
        }

        return key_exists($offset, $this->value);
    }

    /**
     * @psalm-pure
     *
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value): void
    {
        throw new CannotModifyMessException($this->keySequence);
    }

    /**
     * @psalm-pure
     *
     * @param mixed $offset
     */
    public function offsetUnset($offset): void
    {
        throw new CannotModifyMessException($this->keySequence);
    }

    /**
     * @psalm-pure
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
     * @param mixed  $value
     * @param string $expectedType
     */
    private function assertType($value, string $expectedType): void
    {
        if ($value === null) {
            throw new UnexpectedTypeException($expectedType, $this->value, $this->keySequence);
        }
    }

    /**
     * @param mixed  $value
     * @param string $desiredType
     */
    private function assertCastable($value, string $desiredType): void
    {
        if ($value === null) {
            throw new UncastableValueException($desiredType, $this->value, $this->keySequence);
        }
    }
}