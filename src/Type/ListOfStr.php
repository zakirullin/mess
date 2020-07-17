<?php
declare(strict_types=1);

namespace Zakirullin\TypedAccessor\Type;

/**
 * @psalm-immutable
 */
final class ListOfStr implements TypeInterface
{
    /**
     * @var mixed
     */
    private $value;

    /**
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @psalm-pure
     * @psalm-return list<string>
     *
     * @return array|null
     */
    public function __invoke(): ?array
    {
        $listOfMixed = (new ListOfMixed($this->value))();
        if ($listOfMixed === null) {
            return null;
        }

        $listOfString = [];
        /**
         * @psalm-suppress all
         */
        foreach ($listOfMixed as $value) {
            $stringValue = (new Str($value))();
            if ($stringValue === null) {
                return null;
            }

            /**
             * @var string $stringValue
             */
            $listOfString[] = $stringValue;
        }

        return $listOfString;
    }
}