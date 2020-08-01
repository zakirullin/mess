<?php
declare(strict_types=1);

namespace Zakirullin\TypedAccessor\Finder;

final class ArrayOfStringToTypeFinder
{
    /**
     * @psalm-pure
     *
     * @param mixed    $value
     * @param callable $typeChecker
     * @return null
     */
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