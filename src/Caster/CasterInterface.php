<?php
declare(strict_types=1);

namespace Zakirullin\TypedAccessor\Caster;

interface CasterInterface
{
    /**
     * @param $value
     */
    public function __construct($value);

    /**
     * @return mixed
     */
    public function __invoke();
}