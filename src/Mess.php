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
     * @psalm-pure
     *
     * @return int
     */
    public function getInt(): int
    {
        $this->assertType($this->findInt() !== null, TypeEnum::INT);

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
        $this->assertType($this->findBool() !== null, TypeEnum::BOOL);

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
        $this->assertType($this->findString() !== null, TypeEnum::STRING);

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
        $this->assertType($this->findListOfInt() !== null, TypeEnum::LIST_OF_INT);

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
        $this->assertType($this->findListOfString() !== null, TypeEnum::LIST_OF_STRING);

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
        $this->assertType($this->findArrayOfStringToInt() !== null, TypeEnum::ARRAY_OF_STRING_TO_INT);

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
        $this->assertType($this->findArrayOfStringToBool() !== null, TypeEnum::ARRAY_OF_STRING_TO_BOOL);

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
        $this->assertType($this->findArrayOfStringToString() !== null, TypeEnum::ARRAY_OF_STRING_TO_STRING);

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

        $this->assertCastable($intValue !== null, TypeEnum::INT);

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

        $this->assertCastable($boolValue !== null, TypeEnum::BOOL);

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

        $this->assertCastable($stringValue !== null, TypeEnum::STRING);

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

        $this->assertCastable($listOfInt !== null, TypeEnum::LIST_OF_INT);

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

        $this->assertCastable($listOfString !== null, TypeEnum::LIST_OF_STRING);

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

        $this->assertCastable($arrayOfStringToInt !== null, TypeEnum::ARRAY_OF_STRING_TO_INT);

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

        $this->assertCastable($arrayOfStringToBool !== null, TypeEnum::ARRAY_OF_STRING_TO_BOOL);

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

        $this->assertCastable($arrayOfStringToString !== null, TypeEnum::ARRAY_OF_STRING_TO_STRING);

        return $arrayOfStringToString;
    }

    /**
     * @psalm-pure
     *
     * @return int|null
     */
    public function findInt(): ?int
    {
        if ($this->value === null) {
            return null;
        }

        $this->assertType(is_int($this->value), TypeEnum::INT);

        return $this->value;
    }

    /**
     * @psalm-pure
     *
     * @return bool|null
     */
    public function findBool(): ?bool
    {
        if ($this->value === null) {
            return null;
        }

        $this->assertType(is_bool($this->value), TypeEnum::BOOL);

        return $this->value;
    }

    /**
     * @psalm-pure
     *
     * @return string|null
     */
    public function findString(): ?string
    {
        if ($this->value === null) {
            return null;
        }

        $this->assertType(is_string($this->value), TypeEnum::STRING);

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
        if ($this->value === null) {
            return null;
        }

        /**
         * @psalm-var list<int>|null
         */
        $list = ListOfTypeFinder::find($this->value, 'is_int');

        $this->assertType($list !== null, TypeEnum::LIST_OF_INT);

        return $list;
    }

    /**
     * @psalm-pure
     * @psalm-return list<string>|null
     *
     * @return array|null
     */
    public function findListOfString(): ?array
    {
        if ($this->value === null) {
            return null;
        }

        /**
         * @psalm-var list<string>|null
         */
        $list = ListOfTypeFinder::find($this->value, 'is_string');

        $this->assertType($list !== null, TypeEnum::LIST_OF_STRING);

        return $list;
    }

    /**
     * @psalm-pure
     * @psalm-return array<string,int>|null
     *
     * @return array|null
     */
    public function findArrayOfStringToInt(): ?array
    {
        if ($this->value === null) {
            return null;
        }

        /**
         * @psalm-var array<string,int>|null
         */
        $array =  ArrayOfStringToTypeFinder::find($this->value, 'is_int');

        $this->assertType($array !== null, TypeEnum::ARRAY_OF_STRING_TO_INT);

        return $array;
    }

    /**
     * @psalm-pure
     * @psalm-return array<string,bool>|null
     *
     * @return array|null
     */
    public function findArrayOfStringToBool(): ?array
    {
        if ($this->value === null) {
            return null;
        }

        /**
         * @psalm-var array<string,bool>|null
         */
        $array = ArrayOfStringToTypeFinder::find($this->value, 'is_bool');

        $this->assertType($array !== null, TypeEnum::ARRAY_OF_STRING_TO_BOOL);

        return $array;
    }

    /**
     * @psalm-pure
     * @psalm-return array<string,string>|null
     *
     * @return array|null
     */
    public function findArrayOfStringToString(): ?array
    {
        if ($this->value === null) {
            return null;
        }

        /**
         * @psalm-var array<string,string>|null
         */
        $array = ArrayOfStringToTypeFinder::find($this->value, 'is_string');

        $this->assertType($array !== null, TypeEnum::ARRAY_OF_STRING_TO_STRING);

        return $array;
    }

    /**
     * @psalm-pure
     *
     * @return int|null
     */
    public function findAsInt(): ?int
    {
        if ($this->value === null) {
            return null;
        }

        $int = IntCaster::cast($this->value);

        $this->assertCastable($int !== null, TypeEnum::INT);

        return $int;
    }

    /**
     * @psalm-pure
     *
     * @return bool|null
     */
    public function findAsBool(): ?bool
    {
        if ($this->value === null) {
            return null;
        }

        $bool = BoolCaster::cast($this->value);

        $this->assertCastable($bool !== null, TypeEnum::BOOL);

        return $bool;
    }

    /**
     * @psalm-pure
     *
     * @return string|null
     */
    public function findAsString(): ?string
    {
        if ($this->value === null) {
            return null;
        }

        $string = StringCaster::cast($this->value);

        $this->assertCastable($string !== null, TypeEnum::STRING);

        return $string;
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

        /**
         * @psalm-var list<int>|null
         */
        $list = ListOfTypeCaster::cast($this->value, [IntCaster::class, 'cast']);

        $this->assertCastable($list !== null, TypeEnum::LIST_OF_INT);

        return $list;
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

        /**
         * @psalm-var list<string>|null
         */
        $list = ListOfTypeCaster::cast($this->value, [StringCaster::class, 'cast']);

        $this->assertCastable($list !== null, TypeEnum::LIST_OF_STRING);

        return $list;
    }

    /**
     * @psalm-pure
     * @psalm-return array<string,int>|null
     *
     * @return array|null
     */
    public function findAsArrayOfStringToInt(): ?array
    {
        if ($this->value === null) {
            return null;
        }

        /**
         * @psalm-var array<string,int>|null
         */
        $array = ArrayOfStringToTypeCaster::cast($this->value, [IntCaster::class, 'cast']);

        $this->assertCastable($array !== null, TypeEnum::ARRAY_OF_STRING_TO_INT);

        return $array;
    }

    /**
     * @psalm-pure
     * @psalm-return array<string,bool>|null
     *
     * @return array|null
     */
    public function findAsArrayOfStringToBool(): ?array
    {
        if ($this->value === null) {
            return null;
        }

        /**
         * @psalm-var array<string,bool>|null
         */
        $array = ArrayOfStringToTypeCaster::cast($this->value, [BoolCaster::class, 'cast']);

        $this->assertCastable($array !== null, TypeEnum::ARRAY_OF_STRING_TO_BOOL);

        return $array;
    }

    /**
     * @psalm-pure
     * @psalm-return array<string,string>|null
     *
     * @return array|null
     */
    public function findAsArrayOfStringToString(): ?array
    {
        if ($this->value === null) {
            return null;
        }

        /**
         * @psalm-var array<string,string>|null
         */
        $array = ArrayOfStringToTypeCaster::cast($this->value, [StringCaster::class, 'cast']);

        $this->assertCastable($array !== null, TypeEnum::ARRAY_OF_STRING_TO_STRING);

        return $array;
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
        $this->assertType($this->findObject() !== null, TypeEnum::OBJECT);

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
        $this->assertType($this->findArray() !== null, TypeEnum::ARRAY);

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
        $this->assertType($this->findArrayOfStringToMixed() !== null, TypeEnum::ARRAY_OF_STRING_TO_MIXED);

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
        if ($this->value === null) {
            return null;
        }

        $this->assertType(is_object($this->value), TypeEnum::OBJECT);

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
        if ($this->value === null) {
            return null;
        }

        /**
         * @psalm-var array<string,string>|null
         */
        $array = ArrayOfStringToMixedFinder::find($this->value);

        $this->assertType($array !== null, TypeEnum::ARRAY_OF_STRING_TO_MIXED);

        return $array;
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

        return (new self($this->getByOffset($offset)))->setKeySequence($clonedKeySequence);
    }

    /**
     * @psalm-pure
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
         * @var array $this ->value
         */
        return $this->value[$offset];
    }
}