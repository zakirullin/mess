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
    public function testGetInt_Int_ReturnsSameInt()
    {
        $actualValue = (new Mess(1))->getInt();

        $this->assertSame(1, $actualValue);
    }

    public function testGetInt_String_ThrowsUnexpectedTypeException()
    {
        $this->expectException(UnexpectedTypeException::class);

        (new Mess('crusoe'))->getInt();
    }

    public function testGetFloat_FloatValue_ReturnsSameFloatValue()
    {
        $actualValue = (new Mess(1.5))->getFloat();

        $this->assertSame(1.5, $actualValue);
    }

    public function testGetBool_Bool_ReturnsSameBoolValue()
    {
        $actualValue = (new Mess(true))->getBool();

        $this->assertSame(true, $actualValue);
    }

    public function testGetBool_String_ThrowsUnexpectedTypeException()
    {
        $this->expectException(UnexpectedTypeException::class);

        (new Mess('true'))->getBool();
    }

    public function testGetString_String_ReturnsSameString()
    {
        $actualValue = (new Mess('crusoe'))->getString();

        $this->assertSame('crusoe', $actualValue);
    }

    public function testGetString_Int_ThrowsUnexpectedTypeException()
    {
        $this->expectException(UnexpectedTypeException::class);

        (new Mess(1))->getString();
    }

    public function testGetListOfInt_ListOfInt_ReturnsSameListOfInt()
    {
        $actualValue = (new Mess([1, 5, 10]))->getListOfInt();

        $this->assertSame([1, 5, 10], $actualValue);
    }

    /**
     * @dataProvider providerNotAListOfInt
     */
    public function testGetListOfInt_NotAListOfIntGiven_ThrowsUnexpectedTypeException($notAListOfInt)
    {
        $this->expectException(UnexpectedTypeException::class);

        (new Mess($notAListOfInt))->getListOfInt();
    }

    public function providerNotAListOfInt()
    {
        return  [
            'associative array' => [[1, 2 => 3]],
            'array of mixed' => [[1, 'a']],
            'int' => [1],
        ];
    }

    public function testGetListOfFloat_ListOfFloat_ReturnsSameListOfFloat()
    {
        $actualValue = (new Mess([1.2, 0.5]))->getListOfFloat();

        $this->assertSame([1.2, 0.5], $actualValue);
    }

    /**
     * @dataProvider providerNotAListOfFloat
     */
    public function testGetListOfFloat_NotAListOfFloatGiven_ThrowsUnexpectedTypeException($notAListOfFloat)
    {
        $this->expectException(UnexpectedTypeException::class);

        (new Mess($notAListOfFloat))->getListOfFloat();
    }

    public function providerNotAListOfFloat()
    {
        return  [
            'associative array' => [[1.5, 2 => 3.5]],
            'array of mixed' => [[1.5, 'a']],
            'float' => [1.5],
        ];
    }

    public function testGetListOfString_ListOfString_ReturnsSameListOfString()
    {
        $actualValue = (new Mess(['a', 'b']))->getListOfString();

        $this->assertSame(['a', 'b'], $actualValue);
    }

    /**
     * @dataProvider providerNotAListOfString
     */
    public function testGetListOfString_GivenNotAListOfString_ThrowsUnexpectedTypeException($notAListOfString)
    {
        $this->expectException(UnexpectedTypeException::class);

        (new Mess($notAListOfString))->getListOfString();
    }

    public function providerNotAListOfString()
    {
        return  [
            'associative array' => [['s', 2 => 's']],
            'array of mixed' => [['s', 1]],
            'string' => ['s'],
        ];
    }

    public function testGetArrayOfStringToInt_ArrayOfStringToInt_ReturnsSameValue()
    {
        $actualValue = (new Mess(['a' => 1, 'b' => 2]))->getArrayOfStringToInt();

        $this->assertSame(['a' => 1, 'b' => 2], $actualValue);
    }

    public function testGetArrayOfStringToFloat_ArrayOfStringToFloat_ReturnsSameValue()
    {
        $actualValue = (new Mess(['a' => 1.5, 'b' => 2.5]))->getArrayOfStringToFloat();

        $this->assertSame(['a' => 1.5, 'b' => 2.5], $actualValue);
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
            'signed positive int in string' => ['+1', 1],
            'negative int in string' => ['-1', -1],
            'positive zero' => ['+0', 0],
            'negative zero' => ['-0', 0],
            'int in string with trailing spaces' => [' 1 ', 1],
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
            'leading zeroes' => ['001'],
        ];
    }

    /**
     * @dataProvider providerCanCastToFloatValues
     */
    public function testGetAsFloat_GivenCastableValue_ReturnsMatchingCastedValue($value, float $castedValue)
    {
        $actualValue = (new Mess($value))->getAsFloat();

        $this->assertSame($castedValue, $actualValue);
    }

    /**
     * Can cast to int
     */
    public function providerCanCastToFloatValues()
    {
        return [
            'float' => [1.5, 1.5],
            'float in positive int' => [1, 1.0],
            'float in negative int' => [-1, -1.0],
            'positive int in string' => ['1', 1.0],
            'signed positive int in string' => ['+1', 1.0],
            'negative int in string' => ['-1', -1],
            'positive float in string' => ['1.5', 1.5],
            'signed positive float in string' => ['+1.5', 1.5],
            'negative float in string' => ['-1.5', -1.5],
            'positive exponent' => ['1.5E2', 150.0],
            'zero exponent' => ['1.5E0', 1.5],
            'negative exponent' => ['1E-2', 0.01],
            'positive zero' => ['+0', 0],
            'negative zero' => ['-0', 0],
            'short float in string' => ['.5', 0.5],
            'float in string with trailing spaces' => [' 1.5 ', 1.5],
            'leading zeroes' => ['001', 1.0],
        ];
    }

    /**
     * @dataProvider providerCannotCastToFloatValues
     */
    public function testGetAsFloat_GivenUncastableValue_ThrowsUncastableValueException($value)
    {
        $this->expectException(UncastableValueException::class);

        (new Mess($value))->getAsFloat();
    }

    /**
     * Cannot cast to int
     */
    public function providerCannotCastToFloatValues()
    {
        return [
            'object' => [(object) []],
            'array' => [[]],
            'function' => [
                function () {
                },
            ],
            'boolean' => [true],
            'malformed float string' => ['1 25'],
            'malformed exponent' => ['1E'],
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
            'bool in string with trailing spaces' => [' false ', false],
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
            'float in string' => ['1.1'],
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
     * @dataProvider providerCanCastToListOfFloatValues
     */
    public function testGetAsListOfFloat_GivenCastableValue_ReturnsMatchingCastedValue($value, array $castedValue)
    {
        $actualValue = (new Mess($value))->getAsListOfFloat();

        $this->assertSame($castedValue, $actualValue);
    }

    /**
     * Can cast to list of float
     */
    public function providerCanCastToListOfFloatValues()
    {
        return [
            'empty list' => [[], []],
            'list of float' => [[1.5], [1.5]],
            'list of castable to float' => [['1.5'], [1.5]],
        ];
    }

    /**
     * @dataProvider providerCannotCastToListOfFloatValues
     */
    public function testGetAsListOfFloat_GivenUncastableValue_ThrowsUuncastableValueException($value)
    {
        $this->expectException(UncastableValueException::class);

        (new Mess($value))->getAsListOfFloat();
    }

    /**
     * Cannot cast to list of float
     */
    public function providerCannotCastToListOfFloatValues()
    {
        return [
            'not array' => [1.5],
            'associative array' => [[1.5, 2 => 3.5]],
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

    public function testFindInt_StringValue_ThrowsException()
    {
        $this->expectException(UnexpectedTypeException::class);

        (new Mess('crusoe'))->findInt();
    }

    public function testFindInt_Null_ReturnsNull()
    {
        $actualValue = (new Mess(null))->findInt();

        $this->assertNull($actualValue);
    }

    public function testFindFloat_FloatValue_ReturnsSameFloatValue()
    {
        $actualValue = (new Mess(1.5))->findFloat();

        $this->assertSame(1.5, $actualValue);
    }

    public function testFindFloat_StringValue_ThrowsException()
    {
        $this->expectException(UnexpectedTypeException::class);

        (new Mess('crusoe'))->findFloat();
    }

    public function testFindFloat_Null_ReturnsNull()
    {
        $actualValue = (new Mess(null))->findFloat();

        $this->assertNull($actualValue);
    }

    public function testFindBool_BoolValue_ReturnsSameBoolValue()
    {
        $actualValue = (new Mess(true))->findBool();

        $this->assertSame(true, $actualValue);
    }

    public function testFindBool_StringValue_ThrowsException()
    {
        $this->expectException(UnexpectedTypeException::class);

        (new Mess('crusoe'))->findBool();
    }

    public function testFindBool_Null_ReturnsNull()
    {
        $actualValue = (new Mess(null))->findBool();

        $this->assertNull($actualValue);
    }

    public function testFindString_StringValue_ReturnsSameStringValue()
    {
        $actualValue = (new Mess('crusoe'))->findString();

        $this->assertSame('crusoe', $actualValue);
    }

    public function testFindString_GivenUncastableValue_ThrowsException()
    {
        $this->expectException(UnexpectedTypeException::class);

        (new Mess(1))->findString();
    }

    public function testFindString_Null_ReturnsSameNull()
    {
        $actualValue = (new Mess(null))->findString();

        $this->assertNull($actualValue);
    }

    public function testFindListOfInt_ListOfInt_ReturnsSameListOfInt()
    {
        $actualValue = (new Mess([1, 5, 10]))->findListOfInt();

        $this->assertSame([1, 5, 10], $actualValue);
    }

    /**
     * @dataProvider providerNotAListOfInt
     */
    public function testFindListOfInt_GivenNotAListOfInt_ThrowsException($notAListOfInt)
    {
        $this->expectException(UnexpectedTypeException::class);

        (new Mess($notAListOfInt))->findListOfInt();
    }

    public function testFindListOfInt_Null_ReturnsNull()
    {
        $actualValue = (new Mess(null))->findListOfInt();

        $this->assertNull($actualValue);
    }

    public function testFindListOfFloat_ListOfFloat_ReturnsSameListOfFloat()
    {
        $actualValue = (new Mess([1.5, 0.1]))->findListOfFloat();

        $this->assertSame([1.5, 0.1], $actualValue);
    }

    /**
     * @dataProvider providerNotAListOfInt
     */
    public function testFindListOfFloat_GivenNotAListOfFloat_ThrowsException($notAlistOfInt)
    {
        $this->expectException(UnexpectedTypeException::class);

        (new Mess($notAlistOfInt))->findListOfFloat();
    }

    public function testFindListOfString_ListOfStringValue_ReturnsSameListOfStringValue()
    {
        $actualValue = (new Mess(['a', 'b']))->findListOfString();

        $this->assertSame(['a', 'b'], $actualValue);
    }

    /**
     * @dataProvider providerNotAListOfString
     */
    public function testFindListOfString_GivenNotAListOfInt_ThrowsException($notAListOfInt)
    {
        $this->expectException(UnexpectedTypeException::class);

        (new Mess($notAListOfInt))->findListOfString();
    }

    public function testFindListOfString_Null_ReturnsNull()
    {
        $actualValue = (new Mess(null))->findListOfString();

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
    public function testFindAsInt_GivenUncastableValue_ThrowsException($value)
    {
        $this->expectException(UncastableValueException::class);

        (new Mess($value))->findAsInt();
    }

    /**
     * @dataProvider providerCannotCastToFloatValues
     */
    public function testFindAsFloat_GivenUncastableValue_ThrowsException($value)
    {
        $this->expectException(UncastableValueException::class);

        (new Mess($value))->findAsFloat();
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
    public function testFindAsBool_GivenUncastableValue_ThrowsException($value)
    {
        $this->expectException(UncastableValueException::class);

        (new Mess($value))->findAsBool();
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
    public function testFindAsString_GivenUncastableValue_ThrowsException($value)
    {
        $this->expectException(UncastableValueException::class);

        (new Mess($value))->findAsString();
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
    public function testFindAsListOfInt_GivenUncastableValue_ThrowsException($value)
    {
        $this->expectException(UncastableValueException::class);

        (new Mess($value))->findAsListOfInt();
    }

    /**
     * @dataProvider providerCanCastToListOfFloatValues
     */
    public function testFindAsListOfFloat_GivenCastableValue_ReturnsMatchingCastedValue($value, array $castedValue)
    {
        $actualValue = (new Mess($value))->findAsListOfFloat();

        $this->assertSame($castedValue, $actualValue);
    }

    /**
     * @dataProvider providerCannotCastToListOfFloatValues
     */
    public function testFindAsListOfFloat_GivenUncastableValue_ThrowsException($value)
    {
        $this->expectException(UncastableValueException::class);

        (new Mess($value))->findAsListOfFloat();
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
    public function testFindAsListOfString_GivenUncastableValue_ThrowsException($value)
    {
        $this->expectException(UncastableValueException::class);

        (new Mess($value))->findAsListOfString();
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

    public function testFindObject_Array_ThrowsException()
    {
        $this->expectException(UnexpectedTypeException::class);

        (new Mess([]))->findObject();
    }

    public function testFindObject_Null_ReturnsNull()
    {
        $actualValue = (new Mess(null))->findObject();

        $this->assertNull($actualValue);
    }

    public function testFindArray_Array_ReturnsSameArray()
    {
        $actualValue = (new Mess([1]))->findArray();

        $this->assertSame([1], $actualValue);
    }

    public function testFindArray_Int_ThrowsException()
    {
        $this->expectException(UnexpectedTypeException::class);

        (new Mess(1))->findArray();
    }

    public function testFindArray_Null_ReturnsNull()
    {
        $actualValue = (new Mess(null))->findArray();

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