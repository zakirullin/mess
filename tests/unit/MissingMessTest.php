<?php
declare(strict_types=1);

namespace Zakirullin\TypedAccessor\Tests;

use PHPUnit\Framework\TestCase;
use Zakirullin\TypedAccessor\MissingMess;
use Zakirullin\TypedAccessor\Mess;
use Zakirullin\TypedAccessor\Exception\CannotModifyAccessorException;
use Zakirullin\TypedAccessor\Exception\MissingKeyException;

/**
 * @covers \Zakirullin\TypedAccessor\MissingMess
 */
class MissingMessTest extends TestCase
{
    public function testGetInt_CorrectAccessor_ThrowsMissingKeyException()
    {
        $accessor = new MissingMess([]);

        $this->expectException(MissingKeyException::class);

        $accessor->getInt();
    }

    public function testGetBool_CorrectAccessor_ThrowsMissingKeyException()
    {
        $accessor = new MissingMess([]);

        $this->expectException(MissingKeyException::class);

        $accessor->getBool();
    }

    public function testGetString_CorrectAccessor_ThrowsMissingKeyException()
    {
        $accessor = new MissingMess([]);

        $this->expectException(MissingKeyException::class);

        $accessor->getString();
    }

    public function testGetAsInt_CorrectAccessor_ThrowsMissingKeyException()
    {
        $accessor = new MissingMess([]);

        $this->expectException(MissingKeyException::class);

        $accessor->getInt();
    }

    public function testGetAsBool_CorrectAccessor_ThrowsMissingKeyException()
    {
        $accessor = new MissingMess([]);

        $this->expectException(MissingKeyException::class);

        $accessor->getBool();
    }

    public function testGetAsString_CorrectAccessor_ThrowsMissingKeyException()
    {
        $accessor = new MissingMess([]);

        $this->expectException(MissingKeyException::class);

        $accessor->getString();
    }

    public function testFindInt_CorrectAccessor_ReturnsNull()
    {
        $accessor = new MissingMess([]);

        $this->assertNull($accessor->findInt());
    }

    public function testFindBool_CorrectAccessor_ReturnsNull()
    {
        $accessor = new MissingMess([]);

        $this->assertNull($accessor->findBool());
    }

    public function testFindString_CorrectAccessor_ReturnsNull()
    {
        $accessor = new MissingMess([]);

        $this->assertNull($accessor->findString());
    }

    public function testFindAsInt_CorrectAccessor_ReturnsNull()
    {
        $accessor = new MissingMess([]);

        $this->assertNull($accessor->findInt());
    }

    public function testFindAsBool_CorrectAccessor_ReturnsNull()
    {
        $accessor = new MissingMess([]);

        $this->assertNull($accessor->findBool());
    }

    public function testFindAsString_CorrectAccessor_ReturnsNull()
    {
        $accessor = new MissingMess([]);

        $this->assertNull($accessor->findString());
    }

    public function testGetMixed_CorrectAccessor_ThrowsMissingKeyException()
    {
        $accessor = new MissingMess([]);

        $this->expectException(MissingKeyException::class);

        $accessor->getMixed();
    }

    public function testFindMixed_CorrectAccessor_ReturnsNull()
    {
        $accessor = new MissingMess([]);

        $this->assertNull($accessor->findMixed());
    }

    public function testOffsetExists_CorrectAccessor_ReturnsFalse()
    {
        $accessor = new MissingMess([]);

        $this->assertFalse($accessor->offsetExists(0));
    }

    public function testOffsetGet_CorrectAccessor_ReturnsMissingValueAccessor()
    {
        $accessor = new Mess([]);

        $this->assertInstanceOf(MissingMess::class, $accessor[0]);
    }

    public function testOffsetGet_CorrectAccessorWithFluentAccess_ThrowsMissingKeyException()
    {
        $accessor = new Mess([]);
        try {
            $accessor['a']['b']['c']->getInt();
        } catch (MissingKeyException $e) {
            $this->assertSame(['a', 'b', 'c'], $e->getKeySequence());
            return;
        }

        $this->fail();
    }

    public function testOffsetSet_CorrectAccessor_ThrowsCannotModifyAccessorException()
    {
        $accessor = new MissingMess([]);

        $this->expectException(CannotModifyAccessorException::class);

        $accessor[0] = 1;
    }

    public function testOffsetUnset_CorrectAccessor_ThrowsCannotModifyAccessorException()
    {
        $accessor = new MissingMess([]);

        $this->expectException(CannotModifyAccessorException::class);

        unset($accessor[0]);
    }
}