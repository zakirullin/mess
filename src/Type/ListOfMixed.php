<?php
declare(strict_types=1);

namespace Zakirullin\TypedAccessor\Type;

use function array_keys;
use function count;
use function is_array;
use function range;

final class ListOfMixed implements TypeInterface
{
    /**
     * @var mixed
     */
    private $value;

    /**
     * @param $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @psalm-pure
     * @psalm-return list
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

        $isList = array_keys($this->value) === range(0, count($this->value) - 1);
        if (!$isList) {
            return null;
        }

        return $this->value;
    }
}