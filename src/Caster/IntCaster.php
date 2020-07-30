<?php
declare(strict_types=1);

namespace Zakirullin\TypedAccessor\Type;

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
     * @return int|null
     */
    public function cast($value): ?int
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
