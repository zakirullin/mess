<?php
declare(strict_types=1);

namespace Zakirullin\Mess\Checker;

final class ListOfTypeChecker
{
    /**
     * @psalm-pure
     *
     * @param mixed    $value
     * @param callable $typeChecker
     * @return bool
     */
    public static function check($value, callable $typeChecker): bool
    {
        if (!ListOfMixedChecker::check($value)) {
            return false;
        }

        /**
         * @psalm-var list $value
         * @var mixed $val
         */
        foreach ($value as $val) {
            if (!$typeChecker($val)) {
                return false;
            }
        }

        return true;
    }
}