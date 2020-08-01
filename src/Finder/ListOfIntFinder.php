<?php
declare(strict_types=1);

namespace Zakirullin\TypedAccessor\Finder;

use function is_int;

final class ListOfIntFinder
{
    public static function find($value): ?array
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
            if (!is_int($val)) {
                return null;
            }
        }

        /**
         * @psalm-var list<int> $listOfMixed
         */

        return $listOfMixed;
    }
}