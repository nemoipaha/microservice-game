<?php

namespace App\Tests;

use App\Dummy;

final class DummyTest extends \TestCase
{
    public function testFailAssertArrayHasKey()
    {
        $this->assertArrayNotHasKey('foo', Dummy::getConfigArray());
    }

    public function testPassAssertArrayHasKey()
    {
        $this->assertArrayHasKey('storage', Dummy::getConfigArray());
    }
}
