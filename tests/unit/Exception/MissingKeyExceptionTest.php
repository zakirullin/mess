<?php
declare(strict_types=1);

namespace Zakirullin\Mess\Tests\Exception;

use PHPUnit\Framework\TestCase;
use Zakirullin\Mess\Exception\MissingKeyException;

/**
 * @covers \Zakirullin\Mess\Exception\MissingKeyException
 */
class MissingKeyExceptionTest extends TestCase
{

    public function testGetKeySequence_ConstructedWithKeySequence_ReturnsSameKeySequence()
    {
        $e = new MissingKeyException(['a', 'b', 'c']);

        $this->assertSame(['a', 'b', 'c'], $e->getKeySequence());
    }
}