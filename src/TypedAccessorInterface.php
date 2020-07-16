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

    public function getAsInt(): int;
    public function getAsBool(): bool;
    public function getAsString(): string;
    public function getAsListOfInt(): array;
    public function getAsListOfString(): array;

    public function findInt(): ?int;
    public function findBool(): ?bool;
    public function findString(): ?string;
    public function findListOfInt(): ?array;
    public function findListOfString(): ?array;

    public function findAsInt(): ?int;
    public function findAsBool(): ?bool;
    public function findAsString(): ?string;
    public function findAsListOfInt(): ?array;
    public function findAsListOfString(): ?array;

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