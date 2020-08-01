<?php
declare(strict_types=1);

namespace Zakirullin\Mess\Tests\Exception;

use PHPUnit\Framework\TestCase;
use Zakirullin\Mess\Exception\UncastableValueException;

/**
 * @covers \Zakirullin\Mess\Exception\UncastableValueException
 */
class UncastableValueExceptionTest extends TestCase
{
    public function testGetInputType_InputType_ReturnsSameInputType()
    {
        $e = new UncastableValueException('desired', '', []);

        $this->assertSame('desired', $e->getDesiredType());
    }

    public function testGetOutputType_OutputType_ReturnsSameOutputType()
    {
        $e = new UncastableValueException('', 'value', []);

        $this->assertSame('value', $e->getValue());
    }
}