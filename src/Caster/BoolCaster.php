<?php
declare(strict_types=1);

namespace Zakirullin\Mess\Caster;

use function is_bool;
use function is_string;
use function strtolower;

/**
 * @psalm-immutable
 */
final class BoolCaster
{
    /**
     * @psalm-pure
     *
     * @param mixed $value
     * @return bool|null
     */
    public static function cast($value): ?bool
    {
        if (is_bool($value)) {
            return $value;
        }

        $intValue = IntCaster::cast($value);
        if ($intValue === 1) {
            return true;
        }
        if ($intValue === 0) {
            return false;
        }

        if (is_string($value)) {
            $stringValue = strtolower($value);
            if ($stringValue === 'true') {
                return true;
            }

            if ($stringValue === 'false') {
                return false;
            }
        }

        return null;
    }
}