<?php
declare(strict_types=1);

namespace Zakirullin\TypedAccessor;

use ArrayAccess;

interface TypedAccessorInterface extends ArrayAccess
{
    public function getInt(): int;
    public function getBool(): bool;
    public function getString(): string;
    public function getListOfInt(): array;
    public function getListOfString(): array;
    public function getMapOfStringToInt(): array;
    public function getMapOfStringToBool(): array;
    public function getMapOfStringToString(): array;

    public function getAsInt(): int;
    public function getAsBool(): bool;
    public function getAsString(): string;
    public function getAsListOfInt(): array;
    public function getAsListOfString(): array;
    public function getAsMapOfStringToInt(): array;
    public function getAsMapOfStringToBool(): array;
    public function getAsMapOfStringToString(): array;

    public function findInt(): ?int;
    public function findBool(): ?bool;
    public function findString(): ?string;
    public function findListOfInt(): ?array;
    public function findListOfString(): ?array;
    public function findMapOfStringToInt(): ?array;
    public function findMapOfStringToBool(): ?array;
    public function findMapOfStringToString(): ?array;

    public function findAsInt(): ?int;
    public function findAsBool(): ?bool;
    public function findAsString(): ?string;
    public function findAsListOfInt(): ?array;
    public function findAsListOfString(): ?array;
    public function findAsMapOfStringToInt(): ?array;
    public function findAsMapOfStringToBool(): ?array;
    public function findAsMapOfStringToString(): ?array;

    /**
     * @return mixed
     */
    public function getMixed();

    /**
     * @return mixed
     */
    public function findMixed();

    /**
     * @param string|int $offset
     * @return self
     */
    public function offsetGet($offset);
}