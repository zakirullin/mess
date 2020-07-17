<?php
declare(strict_types=1);

namespace Zakirullin\TypedAccessor\Caster;

use function filter_var;
use function is_bool;
use const FILTER_VALIDATE_INT;

final class Integer implements CasterInterface
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
     * @return int|null
     */
    public function __invoke(): ?int
    {
        if (is_bool($this->value)) {
            return null;
        }

        $intValue = filter_var($this->value, FILTER_VALIDATE_INT);
        if ($intValue === false) {
            return null;
        }

        return $intValue;
    }
}
