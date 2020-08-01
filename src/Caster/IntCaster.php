<?php
declare(strict_types=1);

namespace Zakirullin\Mess\Caster;

use function filter_var;
use function is_bool;
use const FILTER_VALIDATE_INT;

/**
 * @psalm-immutable
 */
final class IntCaster
{
    /**
     * @psalm-pure
     *
     * @param mixed $value
     * @return int|null
     */
    public static function cast($value): ?int
    {
        if (is_bool($value)) {
            return null;
        }

        $intValue = filter_var($value, FILTER_VALIDATE_INT);
        if ($intValue === false) {
            return null;
        }

        return $intValue;
    }
}
