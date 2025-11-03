<?php
declare(strict_types=1);

namespace Zakirullin\Mess;

use Zakirullin\Mess\Exception\CannotModifyMessException;
use Zakirullin\Mess\Exception\MissingKeyException;
use Zakirullin\Mess\Exception\UnexpectedKeyTypeException;
use function is_int;
use function is_string;

/**
 * @psalm-immutable
 */
final class MissingMess implements MessInterface
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
     * @return int
     */
    public function getInt(): int
    {
        throw new MissingKeyException($this->keySequence);
    }

    /**
     * @return float
     */
    public function getFloat(): float
    {
        throw new MissingKeyException($this->keySequence);
    }

    /**
     * @return bool
     */
    public function getBool(): bool
    {
        throw new MissingKeyException($this->keySequence);
    }

    /**
     * @return string
     */
    public function getString(): string
    {
        throw new MissingKeyException($this->keySequence);
    }

    /**
     * @psalm-return list<int>
     *
     * @return int[]
     */
    public function getListOfInt(): array
    {
        throw new MissingKeyException($this->keySequence);
    }

    /**
     * @psalm-return list<float>
     *
     * @return float[]
     */
    public function getListOfFloat(): array
    {
        throw new MissingKeyException($this->keySequence);
    }

    /**
     * @psalm-return list<string>
     *
     * @return string[]
     */
    public function getListOfString(): array
    {
        throw new MissingKeyException($this->keySequence);
    }

    /**
     * @psalm-return array<string, int>
     *
     * @return array
     */
    public function getArrayOfStringToInt(): array
    {
        throw new MissingKeyException($this->keySequence);
    }

    /**
     * @psalm-return array<string,float>
     *
     * @return array
     */
    public function getArrayOfStringToFloat(): array
    {
        throw new MissingKeyException($this->keySequence);
    }

    /**
     * @psalm-return array<string, bool>
     *
     * @return array
     */
    public function getArrayOfStringToBool(): array
    {
        throw new MissingKeyException($this->keySequence);
    }

    /**
     * @psalm-return array<string, string>
     *
     * @return array
     */
    public function getArrayOfStringToString(): array
    {
        throw new MissingKeyException($this->keySequence);
    }

    /**
     * @return int
     */
    public function getAsInt(): int
    {
        throw new MissingKeyException($this->keySequence);
    }

    /**
     * @return float
     */
    public function getAsFloat(): float
    {
        throw new MissingKeyException($this->keySequence);
    }

    /**
     * @return bool
     */
    public function getAsBool(): bool
    {
        throw new MissingKeyException($this->keySequence);
    }

    /**
     * @return string
     */
    public function getAsString(): string
    {
        throw new MissingKeyException($this->keySequence);
    }

    /**
     * @psalm-return list<int>
     *
     * @return int[]
     */
    public function getAsListOfInt(): array
    {
        throw new MissingKeyException($this->keySequence);
    }

    /**
     * @psalm-return list<float>
     *
     * @return float[]
     */
    public function getAsListOfFloat(): array
    {
        throw new MissingKeyException($this->keySequence);
    }

    /**
     * @psalm-return list<string>
     *
     * @return string[]
     */
    public function getAsListOfString(): array
    {
        throw new MissingKeyException($this->keySequence);
    }

    /**
     * @psalm-return array<string, int>
     *
     * @return array
     */
    public function getAsArrayOfStringToInt(): array
    {
        throw new MissingKeyException($this->keySequence);
    }

    /**
     * @psalm-return array<string, float>
     *
     * @return array
     */
    public function getAsArrayOfStringToFloat(): array
    {
        throw new MissingKeyException($this->keySequence);
    }

    /**
     * @psalm-return array<string, bool>
     *
     * @return array
     */
    public function getAsArrayOfStringToBool(): array
    {
        throw new MissingKeyException($this->keySequence);
    }

    /**
     * @psalm-return array<string, string>
     *
     * @return array
     */
    public function getAsArrayOfStringToString(): array
    {
        throw new MissingKeyException($this->keySequence);
    }

    /**
     * @return int|null
     */
    public function findInt(): ?int
    {
        return null;
    }

    /**
     * @return float|null
     */
    public function findFloat(): ?float
    {
        return null;
    }

    /**
     * @return bool|null
     */
    public function findBool(): ?bool
    {
        return null;
    }

    /**
     * @return string|null
     */
    public function findString(): ?string
    {
        return null;
    }

    /**
     * @psalm-return list<int>
     *
     * @return int[]|null
     */
    public function findListOfInt(): ?array
    {
        return null;
    }

    /**
     * @psalm-return list<float>
     *
     * @return float[]|null
     */
    public function findListOfFloat(): ?array
    {
        return null;
    }

    /**
     * @psalm-return list<string>
     *
     * @return string[]|null
     */
    public function findListOfString(): ?array
    {
        return null;
    }

    /**
     * @psalm-return array<string, int>|null
     *
     * @return array|null
     */
    public function findArrayOfStringToInt(): ?array
    {
        return null;
    }

    /**
     * @psalm-return array<string, bool>|null
     *
     * @return array|null
     */
    public function findArrayOfStringToBool(): ?array
    {
        return null;
    }

    /**
     * @psalm-return array<string, string>|null
     *
     * @return array|null
     */
    public function findArrayOfStringToString(): ?array
    {
        return null;
    }

    /**
     * @return int|null
     */
    public function findAsInt(): ?int
    {
        return null;
    }

    /**
     * @return float|null
     */
    public function findAsFloat(): ?float
    {
        return null;
    }

    /**
     * @return bool|null
     */
    public function findAsBool(): ?bool
    {
        return null;
    }

    /**
     * @return string|null
     */
    public function findAsString(): ?string
    {
        return null;
    }

    /**
     * @psalm-return list<int>|null
     *
     * @return int[]|null
     */
    public function findAsListOfInt(): ?array
    {
        return null;
    }

    /**
     * @psalm-return list<float>|null
     *
     * @return float[]|null
     */
    public function findAsListOfFloat(): ?array
    {
        return null;
    }

    /**
     * @psalm-return list<string>|null
     *
     * @return string[]|null
     */
    public function findAsListOfString(): ?array
    {
        return null;
    }

    /**
     * @psalm-return array<string, int>|null
     *
     * @return array|null
     */
    public function findAsArrayOfStringToInt(): ?array
    {
        return null;
    }

    /**
     * @psalm-return array<string, float>|null
     *
     * @return array|null
     */
    public function findArrayOfStringToFloat(): ?array
    {
        return null;
    }

    /**
     * @pslam-pure
     * @psalm-return array<string,float>|null
     * @return array|null
     */
    public function findAsArrayOfStringToFloat(): ?array
    {
        return null;
    }

    /**
     * @psalm-return array<string, bool>|null
     *
     * @return array|null
     */
    public function findAsArrayOfStringToBool(): ?array
    {
        return null;
    }

    /**
     * @psalm-return array<string, string>|null
     *
     * @return array|null
     */
    public function findAsArrayOfStringToString(): ?array
    {
        return null;
    }

    /**
     * @return mixed
     */
    public function getMixed()
    {
        throw new MissingKeyException($this->keySequence);
    }

    /**
     * @return object
     */
    public function getObject(): object
    {
        throw new MissingKeyException($this->keySequence);
    }

    /**
     * @return array
     */
    public function getArray(): array
    {
        throw new MissingKeyException($this->keySequence);
    }

    /**
     * @psalm-return array<string, mixed>
     *
     * @return array
     */
    public function getArrayOfStringToMixed(): array
    {
        throw new MissingKeyException($this->keySequence);
    }

    /**
     * @return mixed
     */
    public function findMixed()
    {
        return null;
    }

    /**
     * @return object|null
     */
    public function findObject(): ?object
    {
        return null;
    }

    /**
     * @return array|null
     */
    public function findArray(): ?array
    {
        return null;
    }

    /**
     * @psalm-return array<string, mixed>|null
     *
     * @return array|null
     */
    public function findArrayOfStringToMixed(): ?array
    {
        return null;
    }

    /**
     * @param mixed $offset
     *
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return false;
    }

    /**
     * @param int|string $offset
     */
    public function offsetGet($offset): MessInterface
    {
        /**
         * @psalm-suppress DocblockTypeContradiction
         */
        if (!is_string($offset) && !is_int($offset)) {
            throw new UnexpectedKeyTypeException($offset, $this->keySequence);
        }

        $clonedKeySequence = $this->keySequence;
        $clonedKeySequence[] = $offset;

        return new self($clonedKeySequence);
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value): void
    {
        throw new CannotModifyMessException($this->keySequence);
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset): void
    {
        throw new CannotModifyMessException($this->keySequence);
    }
}
