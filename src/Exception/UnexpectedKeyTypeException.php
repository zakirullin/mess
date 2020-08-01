<?php
declare(strict_types=1);

namespace Zakirullin\Mess\Exception;

use RuntimeException;
use Throwable;

final class UnexpectedKeyTypeException extends RuntimeException implements MessExceptionInterface
{
    /**
     * @var mixed
     */
    private $key;

    /**
     * @psalm-var list<string|int>
     *
     * @var array
     */
    private $keySequence;

    /**
     * @psalm-param list<string|int> $keySequence
     *
     * @param mixed          $key
     * @param array          $keySequence
     * @param Throwable|null $previous
     */
    public function __construct($key, array $keySequence, Throwable $previous = null)
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
     * @psalm-return list<string|int>
     *
     * @return array
     */
    public function getKeySequence(): array
    {
        return $this->keySequence;
    }
}