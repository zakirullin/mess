<?php
declare(strict_types=1);

namespace Zakirullin\TypedAccessor\Caster;

use function is_int;
use function is_string;

/**
 * @psalm-immutable
 */
final class StringCaster
{
    /**
     * @psalm-pure
     *
     * @param $value
     * @return string|null
     */
    public static function cast($value): ?string
    {
        if (is_string($value)) {
            return $value;
        }

        if (is_int($value)) {
            return (string) $value;
        }

        return null;
    }
}