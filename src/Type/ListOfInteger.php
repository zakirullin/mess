<?php
declare(strict_types=1);

namespace Zakirullin\TypedAccessor\Type;

final class ListOfInteger implements TypeInterface
{
    /**
     * @var mixed
     */
    private $value;

    /**
     * @param $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @psalm-pure
     * @psalm-return list<int>|null
     * @return array|null
     */
    public function __invoke(): ?array
    {
        $listOfMixed = (new ListOfMixed($this->value))();
        if ($listOfMixed === null) {
            return null;
        }

        $listOfInt = [];
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
