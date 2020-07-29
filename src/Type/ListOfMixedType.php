<?php
declare(strict_types=1);

namespace Zakirullin\TypedAccessor\Type;

use function array_keys;
use function count;
use function is_array;
use function range;

/**
 * @psalm-immutable
 */
final class ListOfMixedType implements TypeInterface
{
    /**
     * @var mixed
     */
    private $value;

    /**
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @psalm-pure
     * @psalm-return list|null
     *
     * @return array|mixed|null
     */
    public function __invoke()
    {
        if (!is_array($this->value)) {
            return null;
        }

        if (empty($this->value)) {
            return [];
        }

        /**
         * @psalm-var list
         */
        $keys = array_keys($this->value);
        $isList = $keys === range(0, count($this->value) - 1);
        if (!$isList) {
            return null;
        }

        /**
         * @psalm-var list
         */

        return $this->value;
    }
}