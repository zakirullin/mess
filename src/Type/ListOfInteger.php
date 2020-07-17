<?php
declare(strict_types=1);

namespace Zakirullin\TypedAccessor\Type;

/**
 * @psalm-immutable
 */
final class ListOfInteger implements TypeInterface
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
     * @psalm-return list<int>|null
     *
     * @return array|null
     */
    public function __invoke(): ?array
    {
        $listOfMixed = (new ListOfMixed($this->value))();
        if ($listOfMixed === null) {
            return null;
        }

        $listOfInt = [];
        /**
         * @psalm-suppress all
         */
        foreach ($listOfMixed as $value) {
            $intValue = (new Integer($value))();
            if ($intValue === null) {
                return null;
            }

            $listOfInt[] = $intValue;
        }

        return $listOfInt;
    }
}
