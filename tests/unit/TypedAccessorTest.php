<?php
declare(strict_types=1);

namespace Zakirullin\TypedAccessor\Tests;

use PHPUnit\Framework\TestCase;
use Zakirullin\TypedAccessor\MissingValueAccessor;
use Zakirullin\TypedAccessor\TypedAccessor;
use Zakirullin\TypedAccessor\Exception\CannotModifyAccessorException;
use Zakirullin\TypedAccessor\Exception\UncastableValueException;
use Zakirullin\TypedAccessor\Exception\UnexpectedTypeException;
use Zakirullin\TypedAccessor\Exception\UnexpectedKeyTypeException;

/**
 * @covers \Zakirullin\TypedAccessor\TypedAccessor
 */
class TypedAccessorTest extends TestCase
{
    /**
     * Can cast to string
     */
    public function providerCanCastToStringValues()
    {
        return [
            'string' => ['crusoe', 'crusoe'],
            'int' => [1, '1'],
        ];
    }

    /**
     * Cannot cast to string
     */
    public function providerCannotCastToStringValues()
    {
        return [
            'object' => [(object) []],
            'array' => [[]],
            'function' => [function () {}],
            'boolean' => [true],
        ];
    }

    public function testGetInt_IntValue_ReturnsSameIntValue()
    {
        $actualValue = (new TypedAccessor(1))->getInt();

        $this->assertSame(1, $actualValue);
    }

    public function testGetInt_StringValue_ThrowsUnexpectedTypeException()
    {
        $this->expectException(UnexpectedTypeException::class);

        (new TypedAccessor('crusoe'))->getInt();
    }

    public function testGetBool_BoolValue_ReturnsSameBoolValue()
    {
        $actualValue = (new TypedAccessor(true))->getBool();

        $this->assertSame(true, $actualValue);
    }

    public function testGetBool_StringValue_ThrowsUnexpectedTypeException()
    {
        $this->expectException(UnexpectedTypeException::class);

        (new TypedAccessor('true'))->getBool();
    }

    public function testGetString_StringValue_ReturnsSameStringValue()
    {
        $actualValue = (new TypedAccessor('crusoe'))->getString();

        $this->assertSame('crusoe', $actualValue);
    }

    public function testGetString_IntValue_ThrowsUnexpectedTypeException()
    {
        $this->expectException(UnexpectedTypeException::class);

        (new TypedAccessor(1))->getString();
    }

    /**
     * @dataProvider providerCanCastToIntValues
     */
    public function testGetAsInt_GivenCastableValue_ReturnsMatchingCastedValue($value, int $castedValue)
    {
        $actualValue = (new TypedAccessor($value))->getAsInt();

        $this->assertSame($castedValue, $actualValue);
    }

    /**
     * Can cast to int
     */
    public function providerCanCastToIntValues()
    {
        return [
            'int' => [1, 1],
            'int in float' => [1.0, 1],
            'positive int in string' => ['1', 1],
            'negative int in string' => ['-1', -1],
        ];
    }

    /**
     * @dataProvider providerCannotCastToIntValues
     */
    public function testGetAsInt_GivenUncastableValue_ThrowsUncastableValueException($value)
    {
        $this->expectException(UncastableValueException::class);

        (new TypedAccessor($value))->getAsInt();
    }

    /**
     * Cannot cast to int
     */
    public function providerCannotCastToIntValues()
    {
        return [
            'object' => [(object) []],
            'array' => [[]],
            'function' => [function () {}],
            'boolean' => [true],
            'float' => [1.1],
            'float in string' => ['1.1'],
            'malformed int string' => ['1 25'],
        ];
    }

    /**
     * @dataProvider providerCanCastToBoolValues
     */
    public function testGetAsBool_GivenCastableValue_ReturnsMatchingCastedValue($value, bool $castedValue)
    {
        $actualValue = (new TypedAccessor($value))->getAsBool();

        $this->assertSame($castedValue, $actualValue);
    }

    /**
     * Can cast to bool
     */
    public function providerCanCastToBoolValues()
    {
        return [
            'bool true' => [true, true],
            'bool false' => [false, false],
            '0' => [0, false],
            '1' => [1, true],
            '0 in string' => ['0', false],
            '1 in string' => ['1', true],
            'true in string' => ['true', true],
            'false in string' => ['false', false],
        ];
    }

    /**
     * @dataProvider providerCannotCastToBoolValues
     */
    public function testGetAsBool_GivenUncastableValue_ThrowsUncastableValueException($value)
    {
        $this->expectException(UncastableValueException::class);

        (new TypedAccessor($value))->getAsBool();
    }

    /**
     * Cannot cast to bool
     */
    public function providerCannotCastToBoolValues()
    {
        return [
            'object' => [(object) []],
            'array' => [[]],
            'function' => [function () {}],
            'float' => [1.1],
            'True in string' => ['True'],
        ];
    }

    /**
     * @dataProvider providerCanCastToStringValues
     */
    public function testGetAsString_GivenCastableValue_ReturnsMatchingCastedValue($value, string $castedValue)
    {
        $actualValue = (new TypedAccessor($value))->getAsString();

        $this->assertSame($castedValue, $actualValue);
    }

    /**
     * @dataProvider providerCannotCastToStringValues
     */
    public function testGetAsString_GiveUncastableValue_ThrowsUncastableValueException($value)
    {
        $this->expectException(UncastableValueException::class);

        (new TypedAccessor($value))->getAsString();
    }

    public function testFindInt_IntValue_ReturnsSameIntValue()
    {
        $actualValue = (new TypedAccessor(1))->findInt();

        $this->assertSame(1, $actualValue);
    }

    public function testFindInt_StringValue_ReturnsNull()
    {
        $actualValue = (new TypedAccessor('crusoe'))->findInt();

        $this->assertNull($actualValue);
    }

    public function testFindBool_BoolValue_ReturnsSameBoolValue()
    {
        $actualValue = (new TypedAccessor(true))->findBool();

        $this->assertSame(true, $actualValue);
    }

    public function testFindBool_StringValue_ReturnsNull()
    {
        $actualValue = (new TypedAccessor('crusoe'))->findBool();

        $this->assertNull($actualValue);
    }

    public function testFindString_StringValue_ReturnsSameStringValue()
    {
        $actualValue = (new TypedAccessor('crusoe'))->findString();

        $this->assertSame('crusoe', $actualValue);
    }

    public function testFindString_GivenUncastableValue_ReturnsNull()
    {
        $value = (new TypedAccessor(1))->findString();

        $this->assertNull($value);
    }

    /**
     * @dataProvider providerCanCastToIntValues
     */
    public function testFindAsInt_GivenCastableValue_ReturnsMatchingCastedValue($value, int $castedValue)
    {
        $actualValue = (new TypedAccessor($value))->findAsInt();

        $this->assertSame($castedValue, $actualValue);
    }

    /**
     * @dataProvider providerCannotCastToIntValues
     */
    public function testFindAsInt_GivenUncastableValue_ReturnsNull($value)
    {
        $actualValue = (new TypedAccessor($value))->findAsInt();

        $this->assertNull($actualValue);
    }

    /**
     * @dataProvider providerCanCastToBoolValues
     */
    public function testFindAsBool_GivenCastableValue_ReturnsMatchingCastedValue($value, bool $castedValue)
    {
        $actualValue = (new TypedAccessor($value))->findAsBool();

        $this->assertSame($castedValue, $actualValue);
    }

    /**
     * @dataProvider providerCannotCastToBoolValues
     */
    public function testFindAsBool_GivenUncastableValue_ReturnsNull($value)
    {
        $actualValue = (new TypedAccessor($value))->findAsBool();

        $this->assertNull($actualValue);
    }

    /**
     * @dataProvider providerCanCastToStringValues
     */
    public function testFindAsString_GivenCastableValue_ReturnsMatchingCastedValue($value, string $castedValue)
    {
        $actualValue = (new TypedAccessor($value))->findAsString();

        $this->assertSame($castedValue, $actualValue);
    }

    /**
     * @dataProvider providerCannotCastToStringValues
     */
    public function testFindAsString_GivenUncastableValue_ReturnsNull($value)
    {
        $actualValue = (new TypedAccessor($value))->findAsString();

        $this->assertNull($actualValue);
    }

    public function testGetMixed_AnyValue_ReturnsSameValue()
    {
        $actualValue = (new TypedAccessor('1'))->getMixed();

        $this->assertSame('1', $actualValue);
    }

    public function testFindMixedValue_AnyValue_ReturnsSameValue()
    {
        $actualValue = (new TypedAccessor('1'))->findMixed();

        $this->assertSame('1', $actualValue);
    }

    public function testOffsetExists_ArrayWithExistingOffset_ReturnsTrue()
    {
        $accessor = new TypedAccessor([1]);

        $this->assertTrue(isset($accessor[0]));
    }

    public function testOffsetExists_ArrayWithNonExistingOffset_ReturnsFalse()
    {
        $accessor = new TypedAccessor([]);

        $this->assertFalse(isset($accessor[0]));
    }

    public function testOffsetExists_NonArray_ReturnsFalse()
    {
        $accessor = new TypedAccessor(1);

        $this->assertFalse(isset($accessor[0]));
    }

    public function testOffsetGet_ArrayWithExistingOffset_ReturnsTypedValueAccessor()
    {
        $accessor = new TypedAccessor([1]);

        $this->assertInstanceOf(TypedAccessor::class, $accessor[0]);
    }

    public function testOffsetGet_InnerArrayWithExistingOffset_ReturnsTypedValueAccessor()
    {
        $accessor = new TypedAccessor([0 => [0 => 1]]);

        $this->assertInstanceOf(TypedAccessor::class, $accessor[0][0]);
    }

    public function testOffsetGet_ArrayWithNonExistingOffset_ReturnsMissingValueAccessor()
    {
        $accessor = new TypedAccessor([1]);

        $this->assertInstanceOf(MissingValueAccessor::class, $accessor[1]);
    }

    public function testOffsetGet_InnerArrayWithNonExistingOffset_ReturnsMissingValueAccessor()
    {
        $accessor = new TypedAccessor([0 => [0 => 1]]);

        $this->assertInstanceOf(MissingValueAccessor::class, $accessor[0][1]);
    }

    public function testOffsetGet_String_ReturnsValueByKey()
    {
        $accessor = new TypedAccessor(['key' => 1]);

        $this->assertSame(1, $accessor['key']->getInt());
    }

    public function testOffsetGet_Int_ReturnsValueByKey()
    {
        $accessor = new TypedAccessor([0 => 1]);

        $this->assertSame(1, $accessor[0]->getInt());
    }

    public function testOffsetGet_Bool_ThrowsUnexpectedKeyTypeException()
    {
        $accessor = new TypedAccessor([0 => 1]);

        $this->expectException(UnexpectedKeyTypeException::class);

        $accessor[false];
    }

    public function testOffsetSet_Offset_ThrowsCannotModifyAccessorException()
    {
        $this->expectException(CannotModifyAccessorException::class);

        $accessor = new TypedAccessor([1]);
        $accessor[0] = 1;
    }

    public function testOffsetUnset_Offset_ThrowsCannotModifyAccessorException()
    {
        $this->expectException(CannotModifyAccessorException::class);

        $accessor = new TypedAccessor([1]);
        unset($accessor[0]);
    }
}