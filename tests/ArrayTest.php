<?php
use DevLucid\Component\Store;

class ArrayTest extends \PHPUnit_Framework_TestCase
{
    public function testSource()
    {
        # simply create
        $store = new Store();
        $this->assertTrue(is_array($store->getArray()));
    }

    public function testIssetUnset()
    {
        $store = new Store();
        $this->assertFalse($store->is_set('testKey'));
        $store->set('testKey', 'testValue');
        $this->assertTrue($store->is_set('testKey'));
        $store->un_set('testKey');
        $this->assertFalse($store->is_set('testKey'));
    }

    public function testString()
    {
        $store = new Store();
        $store->set('testKey', 'testValue');
        $this->assertTrue($store->is_set('testKey'));
        $this->assertTrue($store->string('testKey') == 'testValue');
        $store->un_set('testKey');
        $this->assertFalse($store->is_set('testKey'));
    }

    public function testStringNoCasting()
    {
        $store = new Store();

        $store->set('testKey', '1');
        $this->assertTrue($store->is_set('testKey'));
        $this->assertFalse(is_integer($store->string('testKey')));
        $this->assertTrue(is_string($store->string('testKey')));
        $this->assertFalse($store->string('testKey') === 1);
        $store->un_set('testKey');
        $this->assertFalse($store->is_set('testKey'));

        $store->set('testKey', 1);
        $this->assertTrue($store->is_set('testKey'));
        $this->assertFalse(is_integer($store->string('testKey')));
        $this->assertTrue(is_string($store->string('testKey')));
        $this->assertFalse($store->string('testKey') === 1);
        $store->un_set('testKey');
        $this->assertFalse($store->is_set('testKey'));
    }

    public function testInteger()
    {
        $store = new Store();
        $store->set('testKey', 1);
        $this->assertTrue($store->is_set('testKey'));
        $this->assertTrue($store->integer('testKey') == 1);
        $store->un_set('testKey');
        $this->assertFalse($store->is_set('testKey'));
    }

    public function testIntegerNoCasting()
    {
        $store = new Store();
        $store->set('testKey', '1');
        $this->assertTrue($store->is_set('testKey'));
        $this->assertTrue(is_integer($store->integer('testKey')));
        $this->assertTrue($store->integer('testKey') === 1);
        $this->assertFalse($store->integer('testKey') === '1');
        $store->un_set('testKey');
        $this->assertFalse($store->is_set('testKey'));

        $store->set('testKey', 1);
        $this->assertTrue($store->is_set('testKey'));
        $this->assertTrue(is_integer($store->integer('testKey')));
        $this->assertTrue($store->integer('testKey') === 1);
        $store->un_set('testKey');
        $this->assertFalse($store->is_set('testKey'));
    }
}