<?php
declare(strict_types=1);

namespace Zakirullin\TypedAccessor\Finder;

final class ListOfTypeFinder
{
    public static function find($value, callable $typeChecker): ?array
    {
        $listOfMixed = ListOfMixedFinder::find($value);
        if ($listOfMixed === null) {
            return null;
        }

        /**
         * @psalm-var list $listOfMixed
         */

        /**
         * @psalm-suppress all
         */
        foreach ($listOfMixed as $val) {
            if (!$typeChecker($val)) {
                return null;
            }
        }

        /**
         * @psalm-var list<int> $listOfMixed
         */

        return $listOfMixed;
    }
}