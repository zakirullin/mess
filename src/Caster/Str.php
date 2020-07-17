<?php
declare(strict_types=1);

namespace Zakirullin\TypedAccessor\Caster;

use function is_int;
use function is_string;

final class Str implements CasterInterface
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
     * @return string|null
     */
    public function __invoke(): ?string
    {
        if (is_string($this->value)) {
            return $this->value;
        }

        if (is_int($this->value)) {
            return (string) $this->value;
        }

        return null;
    }
}