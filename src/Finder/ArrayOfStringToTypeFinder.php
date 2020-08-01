<?php
declare(strict_types=1);

namespace Zakirullin\TypedAccessor\Finder;

use Zakirullin\TypedAccessor\Caster;
use function is_string;

final class ArrayOfStringToTypeFinder
{
    public static function find($value, callable $typeChecker)
    {
        $arrayOfMixed = ArrayOfStringToMixedFinder::find($value);
        if ($arrayOfMixed === null) {
            return null;
        }

        foreach ($arrayOfMixed as $val) {
            if (!$typeChecker($val)) {
                return null;
            }
        }

        return $value;
    }
}