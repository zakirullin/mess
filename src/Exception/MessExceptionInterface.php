<?php
declare(strict_types=1);

namespace Zakirullin\Mess\Exception;

use Throwable;

interface MessExceptionInterface extends Throwable
{
      /** @psalm-return list<string|int>
     *
     * @return array
     */
    public function getKeySequence(): array;
}