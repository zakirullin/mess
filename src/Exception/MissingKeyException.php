<?php
declare(strict_types=1);

namespace Zakirullin\TypedAccessor\Exception;

use RuntimeException;
use Throwable;
use function implode;

final class MissingKeyException extends RuntimeException implements TypedAccessorExceptionInterface
{
    /**
     * @psalm-var list<string|int>
     *
     * @var array
     */
    private $keySequence;

    /**
     * @psalm-param list<string|int> $keySequence
     *
     * @param array          $keySequence
     * @param Throwable|null $previous
     */
    public function __construct(array $keySequence, Throwable $previous = null)
    {
        $this->keySequence = $keySequence;

        $message = "Missing key: '{$this->getAbsoluteKey()}'";

        parent::__construct($message, 0, $previous);
    }

    /**
     * @psalm-return list<string|int>
     *
     * @return array
     */
    public function getKeySequence(): array
    {
        return $this->keySequence;
    }

    /**
     * @return string
     */
    private function getAbsoluteKey(): string
    {
        return implode('.', $this->keySequence);
    }
}