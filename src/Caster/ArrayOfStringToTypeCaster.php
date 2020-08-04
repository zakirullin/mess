<?php
declare(strict_types=1);

namespace Zakirullin\Mess\Caster;

use Zakirullin\Mess\Checker\ArrayOfStringToMixedChecker;

final class ArrayOfStringToTypeCaster
{
    /**
     * @psalm-pure
     * @psalm-return array<string,mixed>|null
     *
     * @param mixed    $value
     * @param callable $caster
     * @return array|null
     */
    public static function cast($value, callable $caster): ?array
    {
        if (!ArrayOfStringToMixedChecker::check($value)) {
            return null;
        }

        $arrayOfStringToCasted = [];
        /**
         * @var string $key
         * @var mixed  $val
         */
        foreach ($value as $key => $val) {
            /**
             * @var mixed
             */
            $castedValue = $caster($val);
            if ($castedValue === null) {
                return null;
            }

            /**
             * @var mixed
             */
            $arrayOfStringToCasted[$key] = $castedValue;
        }

        return $arrayOfStringToCasted;
    }
}