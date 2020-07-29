<?php
declare(strict_types=1);

namespace Zakirullin\TypedAccessor\Type;

use function is_bool;

/**
 * @psalm-immutable
 */
final class BooleanType implements TypeInterface
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
     *
     * @return bool|null
     */
    public function __invoke(): ?bool
    {
        if (is_bool($this->value)) {
            return $this->value;
        }

        if ($this->value === 'true') {
            return true;
        }

        if ($this->value === 'false') {
            return false;
        }

        $intValue = (new IntegerType($this->value))();
        if ($intValue === 1) {
            return true;
        }
        if ($intValue === 0) {
            return false;
        }

        return null;
    }
}