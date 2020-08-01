<?php
declare(strict_types=1);

namespace Zakirullin\TypedAccessor\Finder;

use function is_array;
use function is_string;

final class ArrayOfStringToMixedFinder
{
    public static function find($value): ?array
    {
        if (!is_array($value)) {
            return null;
        }

        foreach ($value as $key => $val) {
            if (!is_string($key)) {
                return null;
            }
        }

        return $value;
    }
}