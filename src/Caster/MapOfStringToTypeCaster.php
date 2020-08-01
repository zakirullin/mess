<?php
declare(strict_types=1);

namespace Zakirullin\TypedAccessor\Caster;

final class MapOfStringToTypeCaster
{
    /**
     * @param mixed    $value
     * @param callable $caster
     * @return array|null
     */
    public static function cast($value, callable $caster): ?array
    {
        $mapOfStringToMixed = self::toMapOfStringToMixed($value);
        if ($mapOfStringToMixed === null) {
            return null;
        }

        $mapOfStringToCasted = [];
        foreach ($value as $key => $val) {
            $castedValue = $caster($val);
            if ($castedValue === null) {
                return null;
            }

            $mapOfStringToCasted[$key] = $castedValue;
        }

        return $mapOfStringToCasted;
    }
}