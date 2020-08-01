<?php
declare(strict_types=1);

namespace Zakirullin\TypedAccessor;

use Zakirullin\TypedAccessor\Caster\BoolCaster;
use Zakirullin\TypedAccessor\Caster\ListOfTypeCaster;
use Zakirullin\TypedAccessor\Caster\ArrayOfStringToTypeCaster;
use Zakirullin\TypedAccessor\Caster\StringCaster;
use Zakirullin\TypedAccessor\Enum\TypeEnum;
use Zakirullin\TypedAccessor\Exception\CannotModifyAccessorException;
use Zakirullin\TypedAccessor\Exception\UncastableValueException;
use Zakirullin\TypedAccessor\Exception\UnexpectedKeyTypeException;
use Zakirullin\TypedAccessor\Exception\UnexpectedTypeException;
use Zakirullin\TypedAccessor\Type\IntCaster;
use function is_array;
use function is_bool;
use function is_int;
use function is_string;
use function key_exists;

/**
 * @psalm-immutable
 */
final class TypedAccessor implements TypedAccessorInterface
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
        $this->assertType($this->findInt(), 'int');

        return $this->value;
    }

    /**
     * @psalm-pure
     *
     * @return bool
     */
    public function getBool(): bool
    {
        $this->assertType($this->findBool(), 'bool');

        return $this->value;
    }

    /**
     * @psalm-pure
     *
     * @return string
     */
    public function getString(): string
    {
        $this->assertType($this->findString(), 'string');

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
        $this->assertType($this->findListOfInt(), 'list_of_int');

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
        $this->assertType($this->findListOfString(), 'list_of_string');

        return $this->value;
    }

    /**
     * @return array
     */
    public function getArrayOfStringToInt(): array
    {
        $this->assertType($this->findArrayOfStringToInt(), 'array_of_string_to_int');

        return $this->value;
    }

    /**
     * @return array
     */
    public function getArrayOfStringToBool(): array
    {
        $this->assertType($this->findArrayOfStringToBool(), 'array_of_string_to_bool');

        return $this->value;
    }

    /**
     * @return array
     */
    public function getArrayOfStringToString(): array
    {
        $this->assertType($this->findArrayOfStringToString(), TypeEnum::ARRAY_OF_STRING_TO_STRING);

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
     *
     * @return array
     */
    public function getAsListOfString(): array
    {
        $listOfString = $this->findAsListOfString();

        $this->assertCastable($listOfString, 'list_of_string');

        return $listOfString;
    }

    /**
     * @return array
     */
    public function getAsArrayOfStringToInt(): array
    {
        $arrayOfStringToInt = $this->findAsArrayOfStringToInt();

        $this->assertCastable($arrayOfStringToInt, 'array_of_string_to_int');

        return $arrayOfStringToInt;
    }

    /**
     * @return array
     */
    public function getAsArrayOfStringToBool(): array
    {
        $arrayOfStringToBool = $this->findAsArrayOfStringToBool();

        $this->assertCastable($arrayOfStringToBool, 'array_of_string_to_bool');

        return $arrayOfStringToBool;
    }

    /**
     * @return array
     */
    public function getAsArrayOfStringToString(): array
    {
        $arrayOfStringToString = $this->findAsArrayOfStringToString();

        $this->assertCastable($arrayOfStringToString, 'array_of_string_to_string');

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
        $listOfMixed = (new ListOfMixedType($this->value))();
        if ($listOfMixed === null) {
            return null;
        }

        /**
         * @psalm-var list $listOfMixed
         */

        /**
         * @psalm-suppress all
         */
        foreach ($this->value as $value) {
            if (!is_int($value)) {
                return null;
            }
        }

        /**
         * @psalm-var list<int> $listOfMixed
         */

        return $listOfMixed;
    }


    /**
     * @psalm-pure
     * @psalm-return list<string>|null
     *
     * @return array|null
     */
    public function findListOfString(): ?array
    {
        $listOfMixed = (new ListOfMixedType($this->value))();
        if ($listOfMixed === null) {
            return null;
        }

        /**
         * @psalm-var list $listOfMixed
         */

        /**
         * @psalm-suppress all
         */
        foreach ($listOfMixed as $value) {
            if (!is_string($value)) {
                return null;
            }
        }

        /**
         * @psalm-var list<string> $listOfMixed
         */

        return $listOfMixed;
    }

    public function findArrayOfStringToInt(): ?array
    {
        $arrayOfMixed = Caster::toArrayOfStringToMixed($this->value);
        if ($arrayOfMixed === null) {
            return null;
        }

        foreach ($arrayOfMixed as $val) {
            if (!is_int($val)) {
                return null;
            }
        }

        return $this->value;
    }

    public function findArrayOfStringToBool(): ?array
    {
        $arrayOfMixed = Caster::toArrayOfStringToMixed($this->value);
        if ($arrayOfMixed === null) {
            return null;
        }

        foreach ($arrayOfMixed as $val) {
            if (!is_bool($val)) {
                return null;
            }
        }

        return $this->value;
    }

    public function findArrayOfStringToString(): ?array
    {
        $arrayOfMixed = Caster::toArrayOfStringToMixed($this->value);
        if ($arrayOfMixed === null) {
            return null;
        }

        foreach ($arrayOfMixed as $val) {
            if (!is_string($val)) {
                return null;
            }
        }

        return $this->value;
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
        return ListOfTypeCaster::cast($this->value, [IntCaster::class, 'cast']);
    }

    /**
     * @psalm-return list<string>|null
     *
     * @return array|null
     */
    public function findAsListOfString(): ?array
    {
        return ListOfTypeCaster::cast($this->value, [StringCaster::class, 'cast']);
    }

    /**
     * @return array|null
     */
    public function findAsArrayOfStringToInt(): ?array
    {
        return ArrayOfStringToTypeCaster::cast($this->value, [IntCaster::class, 'cast']);
    }

    /**
     * @return array|null
     */
    public function findAsArrayOfStringToBool(): ?array
    {
        return ArrayOfStringToTypeCaster::cast($this->value, [BoolCaster::class, 'cast']);
    }

    /**
     * @return array|null
     */
    public function findAsArrayOfStringToString(): ?array
    {
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
     * @psalm-pure
     *
     * @return mixed
     */
    public function findMixed()
    {
        return $this->value;
    }

    /**
     * @psalm-pure
     *
     * @param string|int $offset
     * @return TypedAccessorInterface
     */
    public function offsetGet($offset)
    {
        /**
         * @psalm-suppress DocblockTypeContradiction
         */
        if (!is_string($offset) && !is_int($offset)) {
            throw new UnexpectedKeyTypeException($offset, $this->keySequence);
        }

        $keySequence = $this->keySequence;
        $keySequence[] = $offset;

        if (!$this->offsetExists($offset)) {
            return new MissingValueAccessor($keySequence);
        }

        /**
         * @var array
         */
        $array = $this->value;

        return (new self($array[$offset]))->setKeySequence($keySequence);
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
        throw new CannotModifyAccessorException($this->keySequence);
    }

    /**
     * @psalm-pure
     *
     * @param mixed $offset
     */
    public function offsetUnset($offset): void
    {
        throw new CannotModifyAccessorException($this->keySequence);
    }

    /**
     * @psalm-pure
     * @psalm-param list<string|int> $keySequence
     *
     * @param array $keySequence
     * @return TypedAccessor
     */
    private function setKeySequence(array $keySequence): self
    {
        $this->keySequence = $keySequence;

        return $this;
    }

    /**
     * @param        $value
     * @param string $expectedType
     */
    private function assertType($value, string $expectedType): void
    {
        if ($value === null) {
            throw new UnexpectedTypeException($expectedType, $value, $this->keySequence);
        }
    }

    /**
     * @param        $value
     * @param string $desiredType
     */
    private function assertCastable($value, string $desiredType): void
    {
        if ($value === null) {
            throw new UncastableValueException($desiredType, $this->value, $this->keySequence);
        }
    }
}