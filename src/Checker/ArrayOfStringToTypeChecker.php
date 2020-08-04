<?php
declare(strict_types=1);

namespace Zakirullin\Mess\Checker;

final class ArrayOfStringToTypeChecker
{
    /**
     * @psalm-pure
     *
     * @param mixed    $value
     * @param callable $typeChecker
     * @return bool
     */
    public static function check($value, callable $typeChecker)
    {
        if (!ArrayOfStringToMixedChecker::check($value)) {
            return false;
        }

        /**
         * @psalm-var array<string,mixed> $value
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