<?php
declare(strict_types=1);

namespace Zakirullin\Mess\Checker;

use function array_keys;
use function count;
use function is_array;
use function range;

final class ListOfMixedChecker
{
    /**
     * @psalm-pure
     *
     * @param mixed $value
     * @return bool
     */
    public static function check($value): bool
    {
        if (!is_array($value)) {
            return false;
        }

        if (empty($value)) {
            return true;
        }

        /**
         * @psalm-var list
         */
        $keys = array_keys($value);
        $isList = $keys === range(0, count($value) - 1);
        if (!$isList) {
            return false;
        }

        return true;
    }
}