<?php
declare(strict_types=1);

namespace Zakirullin\TypedAccessor\Tests\Exception;

use PHPUnit\Framework\TestCase;
use Zakirullin\TypedAccessor\Exception\UnexpectedKeyTypeException;

class UnexpectedKeyTypeExceptionTest extends TestCase
{
    public function testGetKey_Key_ReturnsSameKey()
    {
        $e = new UnexpectedKeyTypeException('key', []);

        $this->assertSame('key', $e->getKey());
    }
}