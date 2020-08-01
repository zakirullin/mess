<?php
declare(strict_types=1);

namespace Zakirullin\TypedAccessor;

use Zakirullin\TypedAccessor\Exception\CannotModifyAccessorException;
use Zakirullin\TypedAccessor\Exception\MissingKeyException;
use Zakirullin\TypedAccessor\Exception\UnexpectedKeyTypeException;
use function is_int;
use function is_string;

/**
 * @psalm-immutable
 */
final class MissingValueAccessor implements TypedAccessorInterface
{
    /**
     * @psalm-readonly
     * @psalm-var list<string|int>
     *
     * @var array
     */
    private $keySequence;

    /**
     * @psalm-param list<string|int> $keySequence
     *
     * @param array $keySequence
     */
    public function __construct(array $keySequence)
    {
        $this->keySequence = $keySequence;
    }

    /**
     * @psalm-pure
     *
     * @return int
     */
    public function getInt(): int
    {
        throw new MissingKeyException($this->keySequence);
    }

    /**
     * @psalm-pure
     *
     * @return bool
     */
    public function getBool(): bool
    {
        throw new MissingKeyException($this->keySequence);
    }

    /**
     * @psalm-pure
     *
     * @return string
     */
    public function getString(): string
    {
        throw new MissingKeyException($this->keySequence);
    }

    /**
     * @psalm-pure
     * @psalm-return list<int>
     *
     * @return array
     */
    public function getListOfInt(): array
    {
        throw new MissingKeyException($this->keySequence);
    }

    /**
     * @psalm-pure
     * @psalm-return list<string>
     *
     * @return array
     */
    public function getListOfString(): array
    {
        throw new MissingKeyException($this->keySequence);
    }

    /**
     * @psalm-pure
     * @psalm-return list<string>
     *
     * @return array
     */
    public function getArrayOfStringToInt(): array
    {
        throw new MissingKeyException($this->keySequence);
    }

    /**
     * @psalm-pure
     * @psalm-return list<string>
     *
     * @return array
     */
    public function getArrayOfStringToBool(): array
    {
        throw new MissingKeyException($this->keySequence);
    }

    /**
     * @psalm-pure
     * @psalm-return list<string>
     *
     * @return array
     */
    public function getArrayOfStringToString(): array
    {
        throw new MissingKeyException($this->keySequence);
    }

    /**
     * @psalm-pure
     *
     * @return int
     */
    public function getAsInt(): int
    {
        throw new MissingKeyException($this->keySequence);
    }

    /**
     * @psalm-pure
     *
     * @return bool
     */
    public function getAsBool(): bool
    {
        throw new MissingKeyException($this->keySequence);
    }

    /**
     * @psalm-pure
     *
     * @return string
     */
    public function getAsString(): string
    {
        throw new MissingKeyException($this->keySequence);
    }

    /**
     * @psalm-pure
     * @psalm-return list<int>
     *
     * @return array
     */
    public function getAsListOfInt(): array
    {
        throw new MissingKeyException($this->keySequence);
    }

    /**
     * @psalm-pure
     * @psalm-return list<string>
     *
     * @return array
     */
    public function getAsListOfString(): array
    {
        throw new MissingKeyException($this->keySequence);
    }

    /**
     * @psalm-pure
     * @psalm-return list<string>
     *
     * @return array
     */
    public function getAsArrayOfStringToInt(): array
    {
        throw new MissingKeyException($this->keySequence);
    }

    /**
     * @psalm-pure
     * @psalm-return list<string>
     *
     * @return array
     */
    public function getAsArrayOfStringToBool(): array
    {
        throw new MissingKeyException($this->keySequence);
    }

    /**
     * @psalm-pure
     * @psalm-return list<string>
     *
     * @return array
     */
    public function getAsArrayOfStringToString(): array
    {
        throw new MissingKeyException($this->keySequence);
    }

    /**
     * @psalm-pure
     *
     * @return int|null
     */
    public function findInt(): ?int
    {
        return null;
    }

    /**
     * @psalm-pure
     *
     * @return bool|null
     */
    public function findBool(): ?bool
    {
        return null;
    }

    /**
     * @psalm-pure
     *
     * @return string|null
     */
    public function findString(): ?string
    {
        return null;
    }

    /**
     * @psalm-pure
     * @psalm-return list<int>
     *
     * @return array|null
     */
    public function findListOfInt(): ?array
    {
        return null;
    }

    /**
     * @psalm-pure
     * @psalm-return list<string>
     *
     * @return array|null
     */
    public function findListOfString(): ?array
    {
        return null;
    }

    /**
     * @psalm-pure
     * @psalm-return list<string>
     *
     * @return array|null
     */
    public function findArrayOfStringToInt(): ?array
    {
        return null;
    }

    /**
     * @psalm-pure
     * @psalm-return list<string>
     *
     * @return array|null
     */
    public function findArrayOfStringToBool(): ?array
    {
        return null;
    }

    /**
     * @psalm-pure
     * @psalm-return list<string>
     *
     * @return array|null
     */
    public function findArrayOfStringToString(): ?array
    {
        return null;
    }

    /**
     * @psalm-pure
     *
     * @return int|null
     */
    public function findAsInt(): ?int
    {
        return null;
    }

    /**
     * @psalm-pure
     *
     * @return bool|null
     */
    public function findAsBool(): ?bool
    {
        return null;
    }

    /**
     * @psalm-pure
     *
     * @return string|null
     */
    public function findAsString(): ?string
    {
        return null;
    }

    /**
     * @psalm-pure
     * @psalm-return list<int>|null
     *
     * @return array|null
     */
    public function findAsListOfInt(): ?array
    {
        return null;
    }

    /**
     * @psalm-pure
     * @psalm-return list<string>|null
     *
     * @return array|null
     */
    public function findAsListOfString(): ?array
    {
        return null;
    }

    /**
     * @psalm-pure
     * @psalm-return list<string>
     *
     * @return array|null
     */
    public function findAsArrayOfStringToInt(): ?array
    {
        return null;
    }

    /**
     * @psalm-pure
     * @psalm-return list<string>
     *
     * @return array|null
     */
    public function findAsArrayOfStringToBool(): ?array
    {
        return null;
    }

    /**
     * @psalm-pure
     * @psalm-return list<string>
     *
     * @return array|null
     */
    public function findAsArrayOfStringToString(): ?array
    {
        return null;
    }

    /**
     * @psalm-pure
     *
     * @return mixed
     */
    public function getMixed()
    {
        throw new MissingKeyException($this->keySequence);
    }

    /**
     * @psalm-pure
     *
     * @return object
     */
    public function getObject(): object
    {
        throw new MissingKeyException($this->keySequence);
    }

    /**
     * @psalm-pure
     *            
     * @return array
     */
    public function getArray(): array
    {
        throw new MissingKeyException($this->keySequence);
    }

    /**
     * @psalm-pure
     *
     * @return mixed
     */
    public function findMixed()
    {
        return null;
    }

    /**
     * @psalm-pure
     *
     * @return object|null
     */
    public function findObject(): ?object
    {
        return null;
    }

    /**
     * @psalm-pure
     *
     * @return array|null
     */
    public function findArray(): ?array
    {
        return null;
    }

    /**
     * @psalm-pure
     * @param mixed $offset
     *
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return false;
    }

    /**
     * @psalm-pure
     * @param int|string $offset
     *
     * @return self
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

        return new self($keySequence);
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