<?php
declare(strict_types=1);

namespace Zakirullin\TypedAccessor\Exception;

use RuntimeException;
use Throwable;

final class UnexpectedTypeException extends RuntimeException implements TypedAccessorExceptionInterface
{
    /**
     * @var string
     */
    private $expectedType;

    /**
     * @var mixed
     */
    private $value;

    /**
     * @psalm-var list<string|int>
     *
     * @var array
     */
    private $keySequence;

    /**
     * @psalm-param list<string|int> $keySequence
     *
     * @param string         $expectedType
     * @param mixed          $value
     * @param array          $keySequence
     * @param Throwable|null $previous
     */
    public function __construct(string $expectedType, $value, array $keySequence, Throwable $previous = null)
    {
        $this->expectedType = $expectedType;
        $this->value = $value;
        $this->keySequence = $keySequence;

        $actualType = gettype($value);
        $message = "Expected type is '{$expectedType}', got '{$actualType}' instead";

        parent::__construct($message, 0, $previous);
    }

    /**
     * @return string
     */
    public function getExpectedType(): string
    {
        return $this->expectedType;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
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