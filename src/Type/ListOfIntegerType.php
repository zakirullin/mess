<?php
declare(strict_types=1);

namespace Zakirullin\TypedAccessor\Type;

/**
 * @psalm-immutable
 */
final class ListOfIntegerType implements TypeInterface
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
        $listOfMixed = (new ListOfMixedType($this->value))();
        if ($listOfMixed === null) {
            return null;
        }

        $listOfInt = [];
        /**
         * @psalm-suppress all
         */
        foreach ($listOfMixed as $value) {
            $intValue = (new IntegerType($value))();
            if ($intValue === null) {
                return null;
            }

            $listOfInt[] = $intValue;
        }

        return $listOfInt;
    }
}
