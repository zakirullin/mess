<?php
declare(strict_types=1);

namespace Zakirullin\Mess;

use ArrayAccess;

interface MessInterface extends ArrayAccess
{

    /**
     * @psalm-pure
     *
     * @return int
     */
    public function getInt(): int;

    /**
     * @psalm-pure
     *
     * @return bool
     */
    public function getBool(): bool;

    /**
     * @psalm-pure
     *
     * @return string
     */
    public function getString(): string;

    /**
     * @psalm-pure
     * @psalm-return list<int>
     *
     * @return array
     */
    public function getListOfInt(): array;

    /**
     * @psalm-pure
     * @psalm-return list<string>
     *
     * @return array
     */
    public function getListOfString(): array;

    /**
     * @psalm-pure
     * @psalm-return array<string,int>
     *
     * @return array
     */
    public function getArrayOfStringToInt(): array;

    /**
     * @psalm-pure
     * @psalm-return array<string,bool>
     *
     * @return array
     */
    public function getArrayOfStringToBool(): array;

    /**
     * @psalm-pure
     * @psalm-return array<string,string>
     *
     * @return array
     */
    public function getArrayOfStringToString(): array;

    /**
     * @psalm-pure
     *
     * @return int
     */
    public function getAsInt(): int;

    /**
     * @psalm-pure
     *
     * @return bool
     */
    public function getAsBool(): bool;

    /**
     * @psalm-pure
     *
     * @return string
     */
    public function getAsString(): string;

    /**
     * @psalm-pure
     * @psalm-return list<int>
     *
     * @return array
     */
    public function getAsListOfInt(): array;

    /**
     * @psalm-pure
     * @psalm-return list<string>
     *
     * @return array
     */
    public function getAsListOfString(): array;

    /**
     * @psalm-pure
     * @psalm-return array<string,int>
     *
     * @return array
     */
    public function getAsArrayOfStringToInt(): array;

    /**
     * @psalm-pure
     * @psalm-return array<string,bool>
     *
     * @return array
     */
    public function getAsArrayOfStringToBool(): array;

    /**
     * @psalm-pure
     * @psalm-return array<string,string>
     *
     * @return array
     */
    public function getAsArrayOfStringToString(): array;


    /**
     * @psalm-pure
     *
     * @return int|null
     */
    public function findInt(): ?int;

    /**
     * @psalm-pure
     *
     * @return bool|null
     */
    public function findBool(): ?bool;

    /**
     * @psalm-pure
     *
     * @return string|null
     */
    public function findString(): ?string;

    /**
     * @psalm-pure
     * @psalm-return list<int>|null
     *
     * @return array|null
     */
    public function findListOfInt(): ?array;

    /**
     * @psalm-pure
     * @psalm-return list<string>|null
     *
     * @return array|null
     */
    public function findListOfString(): ?array;

    /**
     * @psalm-pure
     * @psalm-return array<string,int>|null
     *
     * @return array|null
     */
    public function findArrayOfStringToInt(): ?array;

    /**
     * @psalm-pure
     * @psalm-return array<string,bool>|null
     *
     * @return array|null
     */
    public function findArrayOfStringToBool(): ?array;

    /**
     * @psalm-pure
     * @psalm-return array<string,string>|null
     *
     * @return array|null
     */
    public function findArrayOfStringToString(): ?array;


    /**
     * @psalm-pure
     *
     * @return int|null
     */
    public function findAsInt(): ?int;

    /**
     * @psalm-pure
     *
     * @return bool|null
     */
    public function findAsBool(): ?bool;

    /**
     * @psalm-pure
     *
     * @return string|null
     */
    public function findAsString(): ?string;

    /**
     * @psalm-return list<int>|null
     *
     * @return array|null
     */
    public function findAsListOfInt(): ?array;

    /**
     * @psalm-return list<string>|null
     *
     * @return array|null
     */
    public function findAsListOfString(): ?array;

    /**
     * @psalm-pure
     * @psalm-return array<string,int>|null
     *
     * @return array|null
     */
    public function findAsArrayOfStringToInt(): ?array;

    /**
     * @psalm-pure
     * @psalm-return array<string,bool>|null
     *
     * @return array|null
     */
    public function findAsArrayOfStringToBool(): ?array;

    /**
     * @psalm-pure
     * @psalm-return array<string,string>|null
     *
     * @return array|null
     */
    public function findAsArrayOfStringToString(): ?array;


    /**
     * @psalm-pure
     *
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
     * @psalm-pure
     * @psalm-return array<string,mixed>
     *
     * @return array
     */
    public function getArrayOfStringToMixed(): array;


    /**
     * @psalm-pure
     *
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
     * @psalm-pure
     * @psalm-return array<string,mixed>|null
     *
     * @return array|null
     */
    public function findArrayOfStringToMixed(): ?array;

    /**
     * @psalm-pure
     *
     * @param string|int $offset
     * @return MessInterface
     */
    public function offsetGet($offset);
}