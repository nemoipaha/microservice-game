<?php

namespace App\Tests;

use App\Dummy;

class DummyTest extends \TestCase
{
    public function testFailAssertArrayHasKey()
    {
        $this->assertArrayHasKey('foo', Dummy::getConfigArray());
    }

    public function testPassAssertArrayHasKey()
    {
        $this->assertArrayHasKey('storage', Dummy::getConfigArray());
    }
}
