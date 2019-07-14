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

    public function testAssertClassHasAttribute()
    {
        $this->assertClassHasAttribute('foo', Dummy::class);
        $this->assertClassNotHasAttribute('bar', Dummy::class);
    }

    public function testAssertArraySubset()
    {
        $this->assertArraySubset(['debug' => true], Dummy::getConfigArray());
    }

    public function testAssertClassHasStaticAttribute()
    {
        $this->assertClassHasStaticAttribute('locales', Dummy::class);
    }

    public function testAssertRegExp()
    {
        $this->assertRegExp('/^CODE\-\d{2,7}[A-Z]$/', Dummy::getRandomCode());
    }
}
