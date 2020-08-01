<?php
declare(strict_types=1);

namespace Zakirullin\TypedAccessor;

use function array_keys;
use function count;
use function is_array;
use function is_string;
use function range;

final class Caster
{

    public static function toListOfInt($value): ?array
    {
        return self::toListOfCasted($value, [self::class, 'toInt']);
    }

    public static function toListOfString($value): ?array
    {
        return self::toListOfCasted($value, [self::class, 'toInt']);
    }

    public static function toArrayOfStringToInt($value): ?array
    {
        return self::toArrayOfStringToCasted($value, [self::class, 'toInt']);
    }

    public static function toArrayOfStringToBool($value): ?array
    {
        return self::toArrayOfStringToCasted($value, [self::class, 'toBool']);
    }

    public static function toArrayOfStringToString($value): ?array
    {
        return self::toArrayOfStringToCasted($value, [self::class, 'toString']);
    }

    public static function toArrayOfStringToMixed($value): ?array
    {
        $array = self::toArray($value);
        if ($array === null) {
            return null;
        }

        foreach ($value as $key => $val) {
            if (!is_string($key)) {
                return null;
            }
        }

        return $value;
    }

    public static function toArray($value): ?array
    {
        if (is_array($value)) {
            return $value;
        }

        return null;
    }

    /**
     * @param mixed $value
     * @return array|null
     */
    private static function toList($value): ?array
    {
        $array = $this->toArray($value);
        if ($array === null) {
            return null;
        }

        if (empty($array)) {
            return [];
        }

        /**
         * @psalm-var list
         */
        $keys = array_keys($array);
        $isList = $keys === range(0, count($array) - 1);
        if (!$isList) {
            return null;
        }

        /**
         * @psalm-var list
         */

        return $array;
    }

    private static function toListOfCasted($value, callable $caster): ?array
    {
        $list = self::toList($value);
        if ($list === null) {
            return null;
        }

        $listOfCasted = [];
        /**
         * @psalm-suppress all
         */
        foreach ($list as $val) {
            $castedValue = $caster($val);
            if ($castedValue === null) {
                return null;
            }

            $listOfInt[] = $castedValue;
        }

        return $listOfCasted;
    }

    /**
     * @param mixed    $value
     * @param callable $caster
     * @return array|null
     */
    private static function toArrayOfStringToCasted($value, callable $caster): ?array
    {
        $arrayOfStringToMixed = self::toArrayOfStringToMixed($value);
        if ($arrayOfStringToMixed === null) {
            return null;
        }

        $arrayOfStringToCasted = [];
        foreach ($value as $key => $val) {
            $castedValue = $caster($val);
            if ($castedValue === null) {
                return null;
            }

            $arrayOfStringToCasted[$key] = $castedValue;
        }

        return $arrayOfStringToCasted;
    }
}