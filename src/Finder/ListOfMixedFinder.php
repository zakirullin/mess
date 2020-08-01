<?php
declare(strict_types=1);

namespace Zakirullin\Mess\Finder;

use function array_keys;
use function count;
use function is_array;
use function range;

final class ListOfMixedFinder
{
    /**
     * @psalm-pure
     * @psalm-return list|null
     *
     * @param mixed $value
     * @return array|null
     */
    public static function find($value)
    {
        if (!is_array($value)) {
            return null;
        }

        if (empty($value)) {
            return [];
        }

        /**
         * @psalm-var list
         */
        $keys = array_keys($value);
        $isList = $keys === range(0, count($value) - 1);
        if (!$isList) {
            return null;
        }

        /**
         * @psalm-var list
         */

        return $value;
    }
}