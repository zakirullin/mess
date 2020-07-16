<?php
declare(strict_types=1);

namespace Zakirullin\TypedAccessor\Exception;

use RuntimeException;
use Throwable;

final class CannotModifyAccessorException extends RuntimeException implements TypedAccessorExceptionInterface
{
    /**
     * @var array
     */
    private $keySequence;

    /**
     * @param array          $keySequence
     * @param Throwable|null $previous
     */
    public function __construct(array $keySequence, Throwable $previous = null)
    {
        $this->keySequence = $keySequence;

        $message = "TypedAccessor cannot modify it's value";

        parent::__construct($message, 0, $previous);
    }

    /**
     * @psalm-return list<string>
     * @return array
     */
    public function getKeySequence(): array
    {
        return $this->keySequence;
    }
}