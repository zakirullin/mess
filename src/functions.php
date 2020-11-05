<?php
declare(strict_types=1);

namespace Zakirullin\Mess
{
    use function array_keys;
    use function count;
    use function filter_var;
    use function is_array;
    use function is_bool;
    use function is_int;
    use function is_string;
    use function range;
    use function strtolower;
    use const FILTER_VALIDATE_INT;

    /**
     * @psalm-pure
     *
     * @param mixed $value
     * @return int|null
     */
    function toInt($value): ?int
    {
        if (is_bool($value)) {
            return null;
        }

        $intValue = filter_var($value, FILTER_VALIDATE_INT);
        if ($intValue === false) {
            return null;
        }

        return $intValue;
    }

    /**
     * @psalm-pure
     *
     * @param mixed $value
     * @return bool|null
     */
    function toBool($value): ?bool
    {
        if (is_bool($value)) {
            return $value;
        }

        $intValue = toInt($value);
        if ($intValue === 1) {
            return true;
        }
        if ($intValue === 0) {
            return false;
        }

        if (is_string($value)) {
            $stringValue = strtolower($value);
            if ($stringValue === 'true') {
                return true;
            }

            if ($stringValue === 'false') {
                return false;
            }
        }

        return null;
    }

    /**
     * @psalm-pure
     *
     * @param mixed $value
     * @return string|null
     */
    function toString($value): ?string
    {
        if (is_string($value)) {
            return $value;
        }

        if (is_int($value)) {
            return (string) $value;
        }

        return null;
    }

    /**
     * @psalm-pure
     * @psalm-return list
     *
     * @param mixed    $value
     * @param callable $caster
     * @return array|null
     */
    function toListOfType($value, callable $caster): ?array
    {
        if (!isListOfMixed($value)) {
            return null;
        }

        $listOfCasted = [];
        /**
         * @psalm-suppress all
         */
        foreach ($value as $val) {
            $castedValue = $caster($val);
            if ($castedValue === null) {
                return null;
            }

            $listOfCasted[] = $castedValue;
        }

        return $listOfCasted;
    }

    /**
     * @psalm-pure
     * @psalm-return array<string,mixed>|null
     *
     * @param mixed    $value
     * @param pure-callable(mixed) $caster
     * @return array|null
     */
    function toArrayOfStringToType($value, callable $caster): ?array
    {
        if (!isArrayOfStringToMixed($value)) {
            return null;
        }
        /** @var array<string, mixed> $value */
        $arrayOfStringToCasted = [];
        /**
         * @var string $key
         * @var mixed  $val
         */
        foreach ($value as $key => $val) {
            /**
             * @var mixed
             */
            $castedValue = $caster($val);
            if ($castedValue === null) {
                return null;
            }

            /**
             * @var mixed
             */
            $arrayOfStringToCasted[$key] = $castedValue;
        }

        return $arrayOfStringToCasted;
    }

    /**
     * @psalm-pure
     *
     * @param mixed $value
     * @return bool
     */
    function isListOfMixed($value): bool
    {
        if (!is_array($value)) {
            return false;
        }

        if ($value === []) {
            return true;
        }

        /**
         * @psalm-var list
         */
        $keys = array_keys($value);

        return $keys === range(0, count($value) - 1);
    }

    /**
     * @psalm-pure
     *
     * @param mixed    $value
     * @param pure-callable(mixed): bool $typeChecker
     * @return bool
     */
    function isListOfType($value, callable $typeChecker): bool
    {
        if (!isListOfMixed($value)) {
            return false;
        }

        /**
         * @psalm-var list $value
         * @var mixed $val
         */
        foreach ($value as $val) {
            if (!$typeChecker($val)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @psalm-pure
     *
     * @param mixed $value
     * @return bool
     */
    function isArrayOfStringToMixed($value): bool
    {
        if (!is_array($value)) {
            return false;
        }

        /**
         * @var array $value
         * @var mixed $val
         */
        foreach ($value as $key => $val) {
            if (!is_string($key)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @psalm-pure
     *
     * @param mixed    $value
     * @param pure-callable(mixed): bool $isType
     * @return bool
     */
    function isArrayOfStringToType($value, callable $isType)
    {
        if (!isArrayOfStringToMixed($value)) {
            return false;
        }

        /**
         * @psalm-var array<string,mixed> $value
         * @var mixed $val
         */
        foreach ($value as $val) {
            if (!$isType($val)) {
                return false;
            }
        }

        return true;
    }
}
