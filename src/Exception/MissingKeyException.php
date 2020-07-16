<?php
declare(strict_types=1);

namespace Zakirullin\TypedAccessor\Exception;

use RuntimeException;
use Throwable;
use function implode;

final class MissingKeyException extends RuntimeException implements TypedAccessorExceptionInterface
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

        $message = "Missing key: '{$this->getKey()}'";

        parent::__construct($message, 0, $previous);
    }

    /**
     * @return array
     */
    public function getKeySequence(): array
    {
        return $this->keySequence;
    }

    /**
     * @return string
     */
    private function getKey(): string
    {
        $absoluteKey = implode('.', $this->keySequence);

        return $absoluteKey;
    }
}