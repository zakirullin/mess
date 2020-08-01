<?php
declare(strict_types=1);

namespace Zakirullin\TypedAccessor\Caster;

use Zakirullin\TypedAccessor\Type\IntCaster;
use function is_bool;

/**
 * @psalm-immutable
 */
final class BoolCaster
{
    /**
     * @psalm-pure
     *
     * @param $value
     * @return bool|null
     */
    public function cast($value): ?bool
    {
        if (is_bool($value)) {
            return $value;
        }

        if ($value === 'true') {
            return true;
        }

        if ($value === 'false') {
            return false;
        }

        $intValue = IntCaster::cast($value);
        if ($intValue === 1) {
            return true;
        }
        if ($intValue === 0) {
            return false;
        }

        return null;
    }
}