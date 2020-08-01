<?php
declare(strict_types=1);

namespace Zakirullin\Mess\Finder;

final class ListOfTypeFinder
{
    /**
     * @psalm-pure
     * @psalm-return list|null
     *
     * @param mixed    $value
     * @param callable $typeChecker
     * @return array|null
     */
    public static function find($value, callable $typeChecker): ?array
    {
        $listOfMixed = ListOfMixedFinder::find($value);
        if ($listOfMixed === null) {
            return null;
        }

        /**
         * @psalm-var list $listOfMixed
         * @var mixed $val
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