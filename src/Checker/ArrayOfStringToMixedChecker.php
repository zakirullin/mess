<?php
declare(strict_types=1);

namespace Zakirullin\Mess\Checker;

use function is_array;
use function is_string;

final class ArrayOfStringToMixedChecker
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

        /**
         * @var array $value
         * @var mixed $val
         */
        foreach ($value as $key => $val) {
            if (!is_string($key)) {
                return false;
            }
        }

        return true;
    }
}