<?php
declare(strict_types=1);

namespace Zakirullin\TypedAccessor\Caster;

final class ArrayOfStringToTypeCaster
{
    /**
     * @param mixed    $value
     * @param callable $caster
     * @return array|null
     */
    public static function cast($value, callable $caster): ?array
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