<?php
declare(strict_types=1);

namespace Zakirullin\TypedAccessor\Tests\Exception;

use PHPUnit\Framework\TestCase;
use Zakirullin\TypedAccessor\Exception\UnexpectedTypeException;

/**
 * @covers \Zakirullin\TypedAccessor\Exception\UnexpectedTypeException
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