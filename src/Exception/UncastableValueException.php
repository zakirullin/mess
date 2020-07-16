<?php
declare(strict_types=1);

namespace Zakirullin\TypedAccessor\Exception;

use RuntimeException;
use Throwable;

final class UncastableValueException extends RuntimeException implements TypedAccessorExceptionInterface
{
    /**
     * @var string
     */
    private $desiredType;

    /**
     * @var mixed
     */
    private $value;

    /**
     * @var array
     */
    private $keySequence;

    /**
     * @param string         $desiredType
     * @param                $value
     * @param array          $keySequence
     * @param Throwable|null $previous
     */
    public function __construct(string $desiredType, $value, array $keySequence, Throwable $previous = null)
    {
        $this->desiredType = $desiredType;
        $this->value = $value;
        $this->keySequence = $keySequence;

        $actualType = gettype($value);
        $message = "Cannot cast value of type '{$actualType}' to '{$desiredType}'";

        parent::__construct($message, 0, $previous);
    }

    /**
     * @return string
     */
    public function getDesiredType(): string
    {
        return $this->desiredType;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
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