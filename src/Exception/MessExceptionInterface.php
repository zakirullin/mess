<?php
declare(strict_types=1);

namespace Zakirullin\Mess\Exception;

interface MessExceptionInterface
{
    /**
     * @psalm-return list<string|int>
     *
     * @return array
     */
    public function getKeySequence(): array;
}