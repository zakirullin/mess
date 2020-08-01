<?php
declare(strict_types=1);

namespace Zakirullin\TypedAccessor;

use ArrayAccess;

interface MessInterface extends ArrayAccess
{
    public function getInt(): int;
    public function getBool(): bool;
    public function getString(): string;
    public function getListOfInt(): array;
    public function getListOfString(): array;
    public function getArrayOfStringToInt(): array;
    public function getArrayOfStringToBool(): array;
    public function getArrayOfStringToString(): array;

    public function getAsInt(): int;
    public function getAsBool(): bool;
    public function getAsString(): string;
    public function getAsListOfInt(): array;
    public function getAsListOfString(): array;
    public function getAsArrayOfStringToInt(): array;
    public function getAsArrayOfStringToBool(): array;
    public function getAsArrayOfStringToString(): array;

    public function findInt(): ?int;
    public function findBool(): ?bool;
    public function findString(): ?string;
    public function findListOfInt(): ?array;
    public function findListOfString(): ?array;
    public function findArrayOfStringToInt(): ?array;
    public function findArrayOfStringToBool(): ?array;
    public function findArrayOfStringToString(): ?array;

    public function findAsInt(): ?int;
    public function findAsBool(): ?bool;
    public function findAsString(): ?string;
    public function findAsListOfInt(): ?array;
    public function findAsListOfString(): ?array;
    public function findAsArrayOfStringToInt(): ?array;
    public function findAsArrayOfStringToBool(): ?array;
    public function findAsArrayOfStringToString(): ?array;

    /**
     * @return mixed
     */
    public function getMixed();
    public function getObject(): object;
    public function getArray(): array;

    /**
     * @return mixed
     */
    public function findMixed();
    public function findObject(): ?object;
    public function findArray(): ?array;

    /**
     * @param string|int $offset
     * @return self
     */
    public function offsetGet($offset);
}