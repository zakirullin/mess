<?php
declare(strict_types=1);

namespace Zakirullin\TypedAccessor\Exception;

interface TypedAccessorExceptionInterface
{
    /**
     * @psalm-return list<string|int>
     *
     * @return array
     */
    public function getKeySequence(): array;
}