<?php
declare(strict_types=1);

namespace Zakirullin\Mess;

use ArrayAccess;

/**
 * @psalm-suppress MissingTemplateParam
 */
interface MessInterface extends ArrayAccess
{
    /**
     * @return int
     */
    public function getInt(): int;

    /**
     * @return float
     */
    public function getFloat(): float;

    /**
     * @return bool
     */
    public function getBool(): bool;

    /**
     * @return string
     */
    public function getString(): string;

    /**
     * @psalm-return list<int>
     *
     * @return int[]
     */
    public function getListOfInt(): array;

    /**
     * @psalm-return list<float>
     *
     * @return float[]
     */
    public function getListOfFloat(): array;

    /**
     * @psalm-return list<string>
     *
     * @return string[]
     */
    public function getListOfString(): array;

    /**
     * @psalm-return array<string, int>
     *
     * @return array
     */
    public function getArrayOfStringToInt(): array;

    /**
     * @psalm-return array<string, float>
     *
     * @return array
     */
    public function getArrayOfStringToFloat(): array;

    /**
     * @psalm-return array<string, bool>
     *
     * @return array
     */
    public function getArrayOfStringToBool(): array;

    /**
     * @psalm-return array<string, string>
     *
     * @return array
     */
    public function getArrayOfStringToString(): array;

    /**
     * @return int
     */
    public function getAsInt(): int;

    /**
     * @return float
     */
    public function getAsFloat(): float;

    /**
     * @return bool
     */
    public function getAsBool(): bool;

    /**
     * @return string
     */
    public function getAsString(): string;

    /**
     * @psalm-return list<int>
     *
     * @return array
     */
    public function getAsListOfInt(): array;

    /**
     * @psalm-return list<float>
     *
     * @return array
     */
    public function getAsListOfFloat(): array;

    /**
     * @psalm-return list<string>
     *
     * @return array
     */
    public function getAsListOfString(): array;

    /**
     * @psalm-return array<string, int>
     *
     * @return array
     */
    public function getAsArrayOfStringToInt(): array;

    /**
     * @psalm-return array<string, float>
     *
     * @return array
     */
    public function getAsArrayOfStringToFloat(): array;

    /**
     * @psalm-return array<string, bool>
     *
     * @return array
     */
    public function getAsArrayOfStringToBool(): array;

    /**
     * @psalm-return array<string, string>
     *
     * @return array
     */
    public function getAsArrayOfStringToString(): array;

    /**
     * @return int|null
     */
    public function findInt(): ?int;

    /**
     * @return float|null
     */
    public function findFloat(): ?float;

    /**
     * @return bool|null
     */
    public function findBool(): ?bool;

    /**
     * @return string|null
     */
    public function findString(): ?string;

    /**
     * @psalm-return list<int>|null
     *
     * @return int[]|null
     */
    public function findListOfInt(): ?array;

    /**
     * @psalm-return list<float>|null
     *
     * @return float[]|null
     */
    public function findListOfFloat(): ?array;

    /**
     * @psalm-return list<string>|null
     *
     * @return string[]|null
     */
    public function findListOfString(): ?array;

    /**
     * @psalm-return array<string, int>|null
     *
     * @return array|null
     */
    public function findArrayOfStringToInt(): ?array;

    /**
     * @psalm-return array<string, float>|null
     *
     * @return array|null
     */
    public function findArrayOfStringToFloat(): ?array;

    /**
     * @psalm-return array<string, bool>|null
     *
     * @return array|null
     */
    public function findArrayOfStringToBool(): ?array;

    /**
     * @psalm-return array<string, string>|null
     *
     * @return array|null
     */
    public function findArrayOfStringToString(): ?array;

    /**
     * @return int|null
     */
    public function findAsInt(): ?int;

    /**
     * @return float|null
     */
    public function findAsFloat(): ?float;

    /**
     * @return bool|null
     */
    public function findAsBool(): ?bool;

    /**
     * @return string|null
     */
    public function findAsString(): ?string;

    /**
     * @psalm-return list<int>|null
     *
     * @return int[]|null
     */
    public function findAsListOfInt(): ?array;

    /**
     * list<float>|null
     *
     * @return float[]|null
     */
    public function findAsListOfFloat(): ?array;

    /**
     * @psalm-return list<string>|null
     *
     * @return string[]|null
     */
    public function findAsListOfString(): ?array;

    /**
     * @psalm-return array<string, int>|null
     *
     * @return array|null
     */
    public function findAsArrayOfStringToInt(): ?array;

    /**
     * @psalm-return array<string, float>|null
     *
     * @return array|null
     */
    public function findAsArrayOfStringToFloat(): ?array;

    /**
     * @psalm-return array<string, bool>|null
     *
     * @return array|null
     */
    public function findAsArrayOfStringToBool(): ?array;

    /**
     * @psalm-return array<string, string>|null
     *
     * @return array|null
     */
    public function findAsArrayOfStringToString(): ?array;

    /**
     * @return mixed
     */
    public function getMixed();

    /**
     * @return object
     */
    public function getObject(): object;

    /**
     * @return array
     */
    public function getArray(): array;

    /**
     * @psalm-return array<string, mixed>
     *
     * @return array
     */
    public function getArrayOfStringToMixed(): array;

    /**
     * @return mixed
     */
    public function findMixed();

    /**
     * @return object|null
     */
    public function findObject(): ?object;

    /**
     * @return array|null
     */
    public function findArray(): ?array;

    /**
     * @psalm-return array<string, mixed>|null
     *
     * @return array|null
     */
    public function findArrayOfStringToMixed(): ?array;

    /**
     * @param string|int $offset
     * @return MessInterface
     */
    public function offsetGet($offset): MessInterface;
}
