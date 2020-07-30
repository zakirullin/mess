<?php
declare(strict_types=1);

namespace Zakirullin\TypedAccessor\Finder;

use Zakirullin\TypedAccessor\Caster;
use function is_string;

final class MapOfStringToStringFinder
{
    public function find($value)
    {
        $mapOfMixed = Caster::toMapOfStringToMixed($value);
        if ($mapOfMixed === null) {
            return null;
        }

        foreach ($mapOfMixed as $val) {
            if (!is_string($val)) {
                return null;
            }
        }

        return $value;
    }
}