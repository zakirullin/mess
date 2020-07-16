<?php
declare(strict_types=1);

namespace Zakirullin\TypedAccessor\Exception;

use RuntimeException;
use Throwable;

final class UnexpectedKeyTypeException extends RuntimeException implements TypedAccessorExceptionInterface
{
    /**
     * @var mixed
     */
    private $key;

    /**
     * @psalm-var list<string>
     * @var array
     */
    private $keySequence;

    /**
     * @param                $key
     * @param                $keySequence
     * @param Throwable|null $previous
     */
    public function __construct($key, $keySequence, Throwable $previous = null)
    {
        $this->key = $key;
        $this->keySequence = $keySequence;

        $keyType = gettype($key);
        $message = "Unexpected key type: '{$keyType}', expected key types are: string, integer";

        parent::__construct($message, 0, $previous);
    }

    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
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