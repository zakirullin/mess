<?php
declare(strict_types=1);

namespace Zakirullin\Mess\Exception;

use RuntimeException;
use Throwable;
use function gettype;

final class UncastableValueException extends RuntimeException implements MessExceptionInterface
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
     * @psalm-var list<string|int>
     *
     * @var array
     */
    private $keySequence;

    /**
     * @psalm-param list<string|int> $keySequence
     *
     * @param string         $desiredType
     * @param mixed          $value
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
     * @psalm-return list<string|int>
     *
     * @return array
     */
    public function getKeySequence(): array
    {
        return $this->keySequence;
    }
}