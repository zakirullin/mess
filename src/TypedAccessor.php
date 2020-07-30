<?php
declare(strict_types=1);

namespace Zakirullin\TypedAccessor;

use Zakirullin\TypedAccessor\Exception\CannotModifyAccessorException;
use Zakirullin\TypedAccessor\Exception\UncastableValueException;
use Zakirullin\TypedAccessor\Exception\UnexpectedKeyTypeException;
use Zakirullin\TypedAccessor\Exception\UnexpectedTypeException;
use Zakirullin\TypedAccessor\Type\BooleanType;
use Zakirullin\TypedAccessor\Type\IntegerType;
use Zakirullin\TypedAccessor\Type\ListOfIntegerType;
use Zakirullin\TypedAccessor\Type\ListOfMixedType;
use Zakirullin\TypedAccessor\Type\ListOfStr;
use Zakirullin\TypedAccessor\Type\Str;
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
        $intValue = $this->findInt();
        if ($intValue === null) {
            throw new UnexpectedTypeException('int', $this->value, $this->keySequence);
        }

        return $intValue;
    }

    /**
     * @psalm-pure
     *
     * @return bool
     */
    public function getBool(): bool
    {
        $boolValue = $this->findBool();
        if ($boolValue === null) {
            throw new UnexpectedTypeException('bool', $this->value, $this->keySequence);
        }

        return $boolValue;
    }

    /**
     * @psalm-pure
     *
     * @return string
     */
    public function getString(): string
    {
        $stringValue = $this->findString();
        if ($stringValue === null) {
            throw new UnexpectedTypeException('string', $this->value, $this->keySequence);
        }

        return $stringValue;
    }

    /**
     * @psalm-pure
     * @psalm-return list<int>
     *
     * @return array
     */
    public function getListOfInt(): array
    {
        $listOfInt = $this->findListOfInt();
        if ($listOfInt === null) {
            throw new UnexpectedTypeException('list_of_int', $this->value, $this->keySequence);
        }

        return $listOfInt;
    }

    /**
     * @psalm-pure
     * @psalm-return list<string>
     *
     * @return array
     */
    public function getListOfString(): array
    {
        $listOfString = $this->findListOfString();
        if ($listOfString === null) {
            throw new UnexpectedTypeException('list_of_string', $this->value, $this->keySequence);
        }

        return $listOfString;
    }

    public function getMapOfStringToInt(): array
    {
        
    }

    public function getMapOfStringToBool(): array
    {
        // TODO: Implement getMapOfStringToBool() method.
    }

    public function getAsMapOfStringToInt(): array
    {
        // TODO: Implement getAsMapOfStringToInt() method.
    }

    /**
     * @psalm-pure
     *
     * @return int
     */
    public function getAsInt(): int
    {
        $intValue = $this->findAsInt();
        if ($intValue === null) {
            throw new UncastableValueException('int', $this->value, $this->keySequence);
        }

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
        if ($boolValue === null) {
            throw new UncastableValueException('bool', $this->value, $this->keySequence);
        }

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
        if ($stringValue === null) {
            throw new UncastableValueException('string', $this->value, $this->keySequence);
        }

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
        if ($listOfInt === null) {
            throw new UncastableValueException('list_of_int', $this->value, $this->keySequence);
        }

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
        if ($listOfString === null) {
            throw new UncastableValueException('list_of_string', $this->value, $this->keySequence);
        }

        return $listOfString;
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

    public function findMapOfStringToInt(): ?array
    {
        $mapOfMixed = Caster::toMapOfStringToMixed($this->value);
        if ($mapOfMixed === null) {
            return null;
        }

        foreach ($mapOfMixed as $val) {
            if (!is_int($val)) {
                return null;
            }
        }

        return $this->value;
    }

    public function findMapOfStringToBool(): ?array
    {
        $mapOfMixed = Caster::toMapOfStringToMixed($this->value);
        if ($mapOfMixed === null) {
            return null;
        }

        foreach ($mapOfMixed as $val) {
            if (!is_bool($val)) {
                return null;
            }
        }

        return $this->value;
    }

    public function findMapOfStringToString(): ?array
    {
        $mapOfMixed = Caster::toMapOfStringToMixed($this->value);
        if ($mapOfMixed === null) {
            return null;
        }

        foreach ($mapOfMixed as $val) {
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
        return (new IntegerType($this->value))();
    }

    /**
     * @psalm-pure
     *
     * @return bool|null
     */
    public function findAsBool(): ?bool
    {
        return (new BooleanType($this->value))();
    }

    /**
     * @psalm-pure
     *
     * @return string|null
     */
    public function findAsString(): ?string
    {
        return (new Str($this->value))();
    }

    /**
     * @psalm-return list<int>|null
     *
     * @return array|null
     */
    public function findAsListOfInt(): ?array
    {
        return (new ListOfIntegerType($this->value))();
    }

    /**
     * @psalm-return list<string>|null
     *
     * @return array|null
     */
    public function findAsListOfString(): ?array
    {
        return (new ListOfStr($this->value))();
    }

    /**
     * @return array|null
     */
    public function findAsMapOfStringToInt(): ?array
    {
        return Caster::toMapOfStringToInt($this->value);
    }

    /**
     * @return array|null
     */
    public function findAsMapOfStringToBool(): ?array
    {
        return Caster::toMapOfStringToBool($this->value);
    }

    /**
     * @return array|null
     */
    public function findAsMapOfStringToString(): ?array
    {
        return Caster::toMapOfStringToString($this->value);
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
}