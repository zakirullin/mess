<?php
declare(strict_types=1);

namespace Zakirullin\TypedAccessor\Finder;

final class ArrayOfStringToTypeFinder
{
    /**
     * @psalm-pure
     * @psalm-return array<string,mixed>|null
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

        /**
         * @psalm-var array<string,mixed> $arrayOfMixed
         * @var mixed $val
         */
        foreach ($arrayOfMixed as $val) {
            if (!$typeChecker($val)) {
                return null;
            }
        }

        /**
         * @psalm-var array<string,mixed>
         */
        return $value;
    }
}