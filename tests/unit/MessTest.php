<?php
declare(strict_types=1);

namespace Zakirullin\Mess\Tests;

use PHPUnit\Framework\TestCase;
use Zakirullin\Mess\Exception\CannotModifyMessException;
use Zakirullin\Mess\Exception\UncastableValueException;
use Zakirullin\Mess\Exception\UnexpectedKeyTypeException;
use Zakirullin\Mess\Exception\UnexpectedTypeException;
use Zakirullin\Mess\MissingMess;
use Zakirullin\Mess\Mess;
use stdClass;

/**
 * @covers \Zakirullin\Mess\Mess
 */
class MessTest extends TestCase
{
    public function testGetInt_IntValue_ReturnsSameIntValue()
    {
        $actualValue = (new Mess(1))->getInt();

        $this->assertSame(1, $actualValue);
    }

    public function testGetInt_StringValue_ThrowsUnexpectedTypeException()
    {
        $this->expectException(UnexpectedTypeException::class);

        (new Mess('crusoe'))->getInt();
    }

    public function testGetBool_BoolValue_ReturnsSameBoolValue()
    {
        $actualValue = (new Mess(true))->getBool();

        $this->assertSame(true, $actualValue);
    }

    public function testGetBool_StringValue_ThrowsUnexpectedTypeException()
    {
        $this->expectException(UnexpectedTypeException::class);

        (new Mess('true'))->getBool();
    }

    public function testGetString_StringValue_ReturnsSameStringValue()
    {
        $actualValue = (new Mess('crusoe'))->getString();

        $this->assertSame('crusoe', $actualValue);
    }

    public function testGetString_IntValue_ThrowsUnexpectedTypeException()
    {
        $this->expectException(UnexpectedTypeException::class);

        (new Mess(1))->getString();
    }

    public function testGetListOfInt_ListOfIntValue_ReturnsSameListOfIntValue()
    {
        $actualValue = (new Mess([1, 5, 10]))->getListOfInt();

        $this->assertSame([1, 5, 10], $actualValue);
    }

    public function testGetListOfInt_AssociativeArrayOfInt_ThrowsUnexpectedTypeException()
    {
        $this->expectException(UnexpectedTypeException::class);

        (new Mess([1, 2 => 3]))->getListOfInt();
    }

    public function testGetListOfInt_ListOfMixed_ThrowsUnexpectedTypeException()
    {
        $this->expectException(UnexpectedTypeException::class);

        (new Mess(['a']))->getListOfInt();
    }

    public function testGetListOfInt_Int_ThrowsUnexpectedTypeException()
    {
        $this->expectException(UnexpectedTypeException::class);

        (new Mess(1))->getListOfInt();
    }

    public function testGetListOfString_ListOfStringValue_ReturnsSameListOfStringValue()
    {
        $actualValue = (new Mess(['a', 'b']))->getListOfString();

        $this->assertSame(['a', 'b'], $actualValue);
    }

    public function testGetListOfString_AssociativeArrayOfString_ThrowsUnexpectedTypeException()
    {
        $this->expectException(UnexpectedTypeException::class);

        (new Mess(['a', 2 => 'b']))->getListOfString();
    }

    public function testGetListOfString_ListOfMixed_ThrowsUnexpectedTypeException()
    {
        $this->expectException(UnexpectedTypeException::class);

        (new Mess([1]))->getListOfString();
    }

    public function testGetListOfString_Int_ThrowsUnexpectedTypeException()
    {
        $this->expectException(UnexpectedTypeException::class);

        (new Mess(1))->getListOfString();
    }

    public function testGetArrayOfStringToInt_ArrayOfStringToInt_ReturnsSameValue()
    {
        $actualValue = (new Mess(['a' => 1, 'b' => 2]))->getArrayOfStringToInt();

        $this->assertSame(['a' => 1, 'b' => 2], $actualValue);
    }

    public function testGetArrayOfStringToBool_ArrayOfStringToBool_ReturnsSameValue()
    {
        $actualValue = (new Mess(['a' => true, 'b' => false]))->getAsArrayOfStringToBool();

        $this->assertSame(['a' => true, 'b' => false], $actualValue);
    }

    public function testGetArrayOfStringToString_ArrayOfStringToString_ReturnsSameValue()
    {
        $actualValue = (new Mess(['a' => 'A', 'b' => 'B']))->getAsArrayOfStringToString();

        $this->assertSame(['a' => 'A', 'b' => 'B'], $actualValue);
    }

    /**
     * @dataProvider providerCanCastToIntValues
     */
    public function testGetAsInt_GivenCastableValue_ReturnsMatchingCastedValue($value, int $castedValue)
    {
        $actualValue = (new Mess($value))->getAsInt();

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

        (new Mess($value))->getAsInt();
    }

    /**
     * Cannot cast to int
     */
    public function providerCannotCastToIntValues()
    {
        return [
            'object' => [(object) []],
            'array' => [[]],
            'function' => [
                function () {
                },
            ],
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
        $actualValue = (new Mess($value))->getAsBool();

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

        (new Mess($value))->getAsBool();
    }

    /**
     * Cannot cast to bool
     */
    public function providerCannotCastToBoolValues()
    {
        return [
            'object' => [(object) []],
            'array' => [[]],
            'function' => [
                function () {
                },
            ],
            'float' => [1.1],
            'True in string' => ['True'],
        ];
    }

    /**
     * @dataProvider providerCanCastToStringValues
     */
    public function testGetAsString_GivenCastableValue_ReturnsMatchingCastedValue($value, string $castedValue)
    {
        $actualValue = (new Mess($value))->getAsString();

        $this->assertSame($castedValue, $actualValue);
    }

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
     * @dataProvider providerCannotCastToStringValues
     */
    public function testGetAsString_GiveUncastableValue_ThrowsUncastableValueException($value)
    {
        $this->expectException(UncastableValueException::class);

        (new Mess($value))->getAsString();
    }

    /**
     * Cannot cast to string
     */
    public function providerCannotCastToStringValues()
    {
        return [
            'object' => [(object) []],
            'array' => [[]],
            'function' => [
                function () {
                },
            ],
            'boolean' => [true],
        ];
    }

    /**
     * @dataProvider providerCanCastToListOfIntValues
     */
    public function testGetAsListOfInt_GivenCastableValue_ReturnsMatchingCastedValue($value, array $castedValue)
    {
        $actualValue = (new Mess($value))->getAsListOfInt();

        $this->assertSame($castedValue, $actualValue);
    }

    /**
     * Can cast to list of int
     */
    public function providerCanCastToListOfIntValues()
    {
        return [
            'empty list' => [[], []],
            'list of int' => [[1], [1]],
            'list of castable to int' => [['1'], [1]],
        ];
    }

    /**
     * @dataProvider providerCannotCastToListOfIntValues
     */
    public function testGetAsListOfInt_GivenUncastableValue_ThrowsUuncastableValueException($value)
    {
        $this->expectException(UncastableValueException::class);

        (new Mess($value))->getAsListOfInt();
    }

    /**
     * Cannot cast to list of int
     */
    public function providerCannotCastToListOfIntValues()
    {
        return [
            'not array' => [1],
            'associative array' => [[1, 2 => 3]],
            'list of uncastable values' => [['a']],
        ];
    }

    /**
     * @dataProvider providerCanCastToListOfStringValues
     */
    public function testGetAsListOfString_GivenCastableValue_ReturnsMatchingCastedValue($value, array $castedValue)
    {
        $actualValue = (new Mess($value))->getAsListOfString();

        $this->assertSame($castedValue, $actualValue);
    }

    /**
     * Can cast to list of string
     */
    public function providerCanCastToListOfStringValues()
    {
        return [
            'empty list' => [[], []],
            'list of string' => [['crusoe'], ['crusoe']],
            'list of castable to strign' => [[1], ['1']],
        ];
    }

    /**
     * @dataProvider providerCannotCastToListOfStringValues
     */
    public function testGetAsListOfString_GivenUncastableValue_ThrowsUncastableValueException($value)
    {
        $this->expectException(UncastableValueException::class);

        (new Mess($value))->getAsListOfString();
    }

    /**
     * Cannot cast to list<string>
     */
    public function providerCannotCastToListOfStringValues()
    {
        return [
            'not array' => [1],
            'associative array' => [['a', 2 => 'b']],
            'list of uncastable values' => [[true]],
        ];
    }

    /**
     * @dataProvider providerCanCastToArrayOfStringToIntValues
     */
    public function testGetAsArrayOfStringToInt_GivenCastableValue_ReturnsMatchingCastedValue($value, array $castedValue)
    {
        $actualValue = (new Mess($value))->getAsArrayOfStringToInt();

        $this->assertSame($castedValue, $actualValue);
    }

    /**
     * Can cast to array<string,int>
     */
    public function providerCanCastToArrayOfStringToIntValues()
    {
        return [
            'empty array' => [[], []],
            'array<string,int>' => [['a' => 1], ['a' => 1]],
            'array<string,castable>' => [['a' => '1'], ['a' => 1]],
        ];
    }

    /**
     * @dataProvider providerCannotCastToArrayOfStringToIntValues
     */
    public function testGetAsArrayOfStringToInt_GivenUncastableValue_ThrowsUncastableValueException($value)
    {
        $this->expectException(UncastableValueException::class);

        (new Mess($value))->getAsArrayOfStringToInt();
    }

    /**
     * Cannot cast to list<string>
     */
    public function providerCannotCastToArrayOfStringToIntValues()
    {
        return [
            'not array' => [1],
            'array<mixed,int>' => [[1 => 1, 'a' => 'b']],
            'array<string,uncastable>' => [[true]],
        ];
    }

    public function testFindInt_IntValue_ReturnsSameIntValue()
    {
        $actualValue = (new Mess(1))->findInt();

        $this->assertSame(1, $actualValue);
    }

    public function testFindInt_StringValue_ReturnsNull()
    {
        $actualValue = (new Mess('crusoe'))->findInt();

        $this->assertNull($actualValue);
    }

    public function testFindBool_BoolValue_ReturnsSameBoolValue()
    {
        $actualValue = (new Mess(true))->findBool();

        $this->assertSame(true, $actualValue);
    }

    public function testFindBool_StringValue_ReturnsNull()
    {
        $actualValue = (new Mess('crusoe'))->findBool();

        $this->assertNull($actualValue);
    }

    public function testFindString_StringValue_ReturnsSameStringValue()
    {
        $actualValue = (new Mess('crusoe'))->findString();

        $this->assertSame('crusoe', $actualValue);
    }

    public function testFindString_GivenUncastableValue_ReturnsNull()
    {
        $value = (new Mess(1))->findString();

        $this->assertNull($value);
    }

    public function testFindListOfInt_ListOfIntValue_ReturnsSameListOfIntValue()
    {
        $actualValue = (new Mess([1, 5, 10]))->findListOfInt();

        $this->assertSame([1, 5, 10], $actualValue);
    }

    public function testFindListOfInt_AssociativeArrayOfInt_ReturnsNull()
    {
        $actualValue = (new Mess([1, 2 => 3]))->findListOfInt();

        $this->assertNull($actualValue);
    }

    public function testFindListOfInt_ListOfMixed_ReturnsNull()
    {
        $actualValue = (new Mess(['a']))->findListOfInt();

        $this->assertNull($actualValue);
    }

    public function testFindListOfInt_Int_ReturnsNull()
    {
        $actualValue = (new Mess(1))->findListOfInt();

        $this->assertNull($actualValue);
    }

    public function testFindListOfString_ListOfStringValue_ReturnsSameListOfStringValue()
    {
        $actualValue = (new Mess(['a', 'b']))->findListOfString();

        $this->assertSame(['a', 'b'], $actualValue);
    }

    public function testFindListOfString_AssociativeArrayOfString_ReturnsNull()
    {
        $actualValue = (new Mess(['a', 2 => 'b']))->findListOfString();

        $this->assertNull($actualValue);
    }

    public function testFindListOfString_ListOfMixed_ReturnsNull()
    {
        $actualValue = (new Mess([1]))->findListOfString();

        $this->assertNull($actualValue);
    }

    public function testFindListOfString_Int_ReturnsNull()
    {
        $actualValue = (new Mess(1))->findListOfString();

        $this->assertNull($actualValue);
    }

    /**
     * @dataProvider providerCanCastToIntValues
     */
    public function testFindAsInt_GivenCastableValue_ReturnsMatchingCastedValue($value, int $castedValue)
    {
        $actualValue = (new Mess($value))->findAsInt();

        $this->assertSame($castedValue, $actualValue);
    }

    /**
     * @dataProvider providerCannotCastToIntValues
     */
    public function testFindAsInt_GivenUncastableValue_ReturnsNull($value)
    {
        $actualValue = (new Mess($value))->findAsInt();

        $this->assertNull($actualValue);
    }

    /**
     * @dataProvider providerCanCastToBoolValues
     */
    public function testFindAsBool_GivenCastableValue_ReturnsMatchingCastedValue($value, bool $castedValue)
    {
        $actualValue = (new Mess($value))->findAsBool();

        $this->assertSame($castedValue, $actualValue);
    }

    /**
     * @dataProvider providerCannotCastToBoolValues
     */
    public function testFindAsBool_GivenUncastableValue_ReturnsNull($value)
    {
        $actualValue = (new Mess($value))->findAsBool();

        $this->assertNull($actualValue);
    }

    /**
     * @dataProvider providerCanCastToStringValues
     */
    public function testFindAsString_GivenCastableValue_ReturnsMatchingCastedValue($value, string $castedValue)
    {
        $actualValue = (new Mess($value))->findAsString();

        $this->assertSame($castedValue, $actualValue);
    }

    /**
     * @dataProvider providerCannotCastToStringValues
     */
    public function testFindAsString_GivenUncastableValue_ReturnsNull($value)
    {
        $actualValue = (new Mess($value))->findAsString();

        $this->assertNull($actualValue);
    }

    /**
     * @dataProvider providerCanCastToListOfIntValues
     */
    public function testFindAsListOfInt_GivenCastableValue_ReturnsMatchingCastedValue($value, array $castedValue)
    {
        $actualValue = (new Mess($value))->findAsListOfInt();

        $this->assertSame($castedValue, $actualValue);
    }

    /**
     * @dataProvider providerCannotCastToListOfIntValues
     */
    public function testFindAsListOfInt_GivenUncastableValue_ReturnsNull($value)
    {
        $actualValue = (new Mess($value))->findAsListOfInt();

        $this->assertNull($actualValue);
    }

    /**
     * @dataProvider providerCanCastToListOfStringValues
     */
    public function testFindAsListOfString_GivenCastableValue_ReturnsMatchingCastedValue($value, array $castedValue)
    {
        $actualValue = (new Mess($value))->findAsListOfString();

        $this->assertSame($castedValue, $actualValue);
    }

    /**
     * @dataProvider providerCannotCastToListOfStringValues
     */
    public function testFindAsListOfString_GivenUncastableValue_ReturnsNull($value)
    {
        $actualValue = (new Mess($value))->findAsListOfString();

        $this->assertNull($actualValue);
    }

    public function testGetMixed_AnyValue_ReturnsSameValue()
    {
        $actualValue = (new Mess('1'))->getMixed();

        $this->assertSame('1', $actualValue);
    }

    public function testGetObject_Object_ReturnsSameObject()
    {
        $object = new stdClass();
        $actualValue = (new Mess($object))->getObject();

        $this->assertSame($object, $actualValue);
    }

    public function testGetObject_Int_ThrowsUnexpectedTypeException()
    {
        $this->expectException(UnexpectedTypeException::class);

        (new Mess(1))->getObject();
    }

    public function testGetArray_Array_ReturnsSameArray()
    {
        $actualValue = (new Mess([1]))->getArray();

        $this->assertSame([1], $actualValue);
    }

    public function testGetArray_Int_ThrowsUnexpectedTypeException()
    {
        $this->expectException(UnexpectedTypeException::class);

        (new Mess(1))->getArray();
    }

    public function testFindMixed_AnyValue_ReturnsSameValue()
    {
        $actualValue = (new Mess('1'))->findMixed();

        $this->assertSame('1', $actualValue);
    }

    public function testFindObject_Object_ReturnsSameObject()
    {
        $object = new stdClass();
        $actualValue = (new Mess($object))->findObject();

        $this->assertSame($object, $actualValue);
    }

    public function testFindObject_Array_ReturnsNull()
    {
        $actualValue = (new Mess([]))->findObject();

        $this->assertNull($actualValue);
    }

    public function testFindArray_Array_ReturnsSameArray()
    {
        $actualValue = (new Mess([1]))->findArray();

        $this->assertSame([1], $actualValue);
    }

    public function testFindArray_Int_ReturnsNull()
    {
        $actualValue = (new Mess(1))->findArray();

        $this->assertNull($actualValue);
    }

    public function testOffsetExists_ArrayWithExistingOffset_ReturnsTrue()
    {
        $accessor = new Mess([1]);

        $this->assertTrue(isset($accessor[0]));
    }

    public function testOffsetExists_ArrayWithNonExistingOffset_ReturnsFalse()
    {
        $accessor = new Mess([]);

        $this->assertFalse(isset($accessor[0]));
    }

    public function testOffsetExists_NonArray_ReturnsFalse()
    {
        $accessor = new Mess(1);

        $this->assertFalse(isset($accessor[0]));
    }

    public function testOffsetGet_ArrayWithExistingOffset_ReturnsTypedValueAccessor()
    {
        $accessor = new Mess([1]);

        $this->assertInstanceOf(Mess::class, $accessor[0]);
    }

    public function testOffsetGet_InnerArrayWithExistingOffset_ReturnsTypedValueAccessor()
    {
        $accessor = new Mess([0 => [0 => 1]]);

        $this->assertInstanceOf(Mess::class, $accessor[0][0]);
    }

    public function testOffsetGet_ArrayWithNonExistingOffset_ReturnsMissingValueAccessor()
    {
        $accessor = new Mess([1]);

        $this->assertInstanceOf(MissingMess::class, $accessor[1]);
    }

    public function testOffsetGet_InnerArrayWithNonExistingOffset_ReturnsMissingValueAccessor()
    {
        $accessor = new Mess([0 => [0 => 1]]);

        $this->assertInstanceOf(MissingMess::class, $accessor[0][1]);
    }

    public function testOffsetGet_String_ReturnsValueByKey()
    {
        $accessor = new Mess(['key' => 1]);

        $this->assertSame(1, $accessor['key']->getInt());
    }

    public function testOffsetGet_Int_ReturnsValueByKey()
    {
        $accessor = new Mess([0 => 1]);

        $this->assertSame(1, $accessor[0]->getInt());
    }

    public function testOffsetGet_Bool_ThrowsUnexpectedKeyTypeException()
    {
        $accessor = new Mess([0 => 1]);

        $this->expectException(UnexpectedKeyTypeException::class);

        $accessor[false];
    }

    public function testOffsetSet_Offset_ThrowsCannotModifyAccessorException()
    {
        $this->expectException(CannotModifyMessException::class);

        $accessor = new Mess([1]);
        $accessor[0] = 1;
    }

    public function testOffsetUnset_Offset_ThrowsCannotModifyAccessorException()
    {
        $this->expectException(CannotModifyMessException::class);

        $accessor = new Mess([1]);
        unset($accessor[0]);
    }
}