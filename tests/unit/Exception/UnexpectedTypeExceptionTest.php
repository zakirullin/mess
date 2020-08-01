<?php
declare(strict_types=1);

namespace Zakirullin\Mess\Tests\Exception;

use PHPUnit\Framework\TestCase;
use Zakirullin\Mess\Exception\UnexpectedTypeException;

/**
 * @covers \Zakirullin\Mess\Exception\UnexpectedTypeException
 */
class UnexpectedTypeExceptionTest extends TestCase
{
    public function testGetExpectedType_ExpectedType_ReturnsSameExpectedType()
    {
        $e = new UnexpectedTypeException('expected', '', []);

        $this->assertSame('expected', $e->getExpectedType());
    }

    public function testGetActualType_ActualType_ReturnsSameActualType()
    {
        $e = new UnexpectedTypeException('', 'value', []);

        $this->assertSame('value', $e->getValue());
    }
}