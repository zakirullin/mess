<?php
declare(strict_types=1);

namespace Zakirullin\Mess\Caster;

use Zakirullin\Mess\Checker\ListOfMixedChecker;

final class ListOfTypeCaster
{
    /**
     * @psalm-pure
     * @psalm-return list
     *
     * @param mixed    $value
     * @param callable $caster
     * @return array|null
     */
    public static function cast($value, callable $caster): ?array
    {
        if (!ListOfMixedChecker::check($value)) {
            return null;
        }

        $listOfCasted = [];
        /**
         * @psalm-suppress all
         */
        foreach ($value as $val) {
            $castedValue = $caster($val);
            if ($castedValue === null) {
                return null;
            }

            $listOfCasted[] = $castedValue;
        }

        return $listOfCasted;
    }
}