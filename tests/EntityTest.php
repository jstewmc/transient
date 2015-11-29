<?php
/**
 * The file for the EntityTest class
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2015 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Transient;

use Jstewmc\Transient\Tests\Foo;
use Jstewmc\Transient\Tests\Bar; 
use Jstewmc\Transient\Tests\Baz;

use Jstewmc\Transient\Tests\Blank;     // a class with no properties/methods
use Jstewmc\Transient\Tests\Closed;    // a class with protected properties/methods
use Jstewmc\Transient\Tests\Open;      // a class with public properties/methods
use Jstewmc\Transient\Tests\Required;  // a class with required properties/methods

use Jstewmc\Transient\Tests\FooPropertyCollision;
use Jstewmc\Transient\Tests\FooMethodCollision;

use Jstewmc\Refraction\RefractionClass;
use Jstewmc\Refraction\RefractionMethod;
use Jstewmc\Refraction\RefractionProperty;


/**
 * Tests for the Entity class
 *
 * @since  0.1.0
 */
class EntityTest extends \PHPUnit_Framework_TestCase
{
    /* !__call() */
    
    /**
     * __call() should throw a BadMethodCallException if method does not exist
     */
    public function test___call_throwsBadMethodCallException_ifMethodDoesNotExist()
    {
        $this->setExpectedException('BadMethodCallException');
        
        (new Blank())->foo();
        
        return;
    }
    
    /**
     * __call() should throw a BadMethodCallException if method is not visible
     */
    public function test___call_throwsBadMethodCallException_ifMethodIsNotVisible()
    {
        $this->setExpectedException('BadMethodCallException');
        
        (new Foo())->attach(new Closed())->getClosed();
        
        return;
    }
    
    /**
     * __call() should return result if method is visible
     */
    public function test___call_returnsResult_ifMethodIsVisible()
    {
        $foo = new Foo();
        $bar = new Bar();
        $baz = new Baz();
        
        $bar->attach($baz);
        $foo->attach($bar);
        
        $value = 'qux';
        
        // let's throw some hoops in here to test the getCallingClass() method and
        //     make sure it can handle looping through different levels of the entity
        //     between __call(), __get(), and __set()
        //
        $this->assertSame($foo, $foo->setBaz($value));
        $this->assertEquals($value, $foo->getBaz());
        
        return;
    }
    
    
    /* !__get() */
    
    /**
     * __get() should throw OutOfBoundsException if property does not exist
     */
    public function test___get_throwsOutOfBoundsException_ifPropertyDoesNotExist()
    {
        $this->setExpectedException('OutOfBoundsException');
        
        (new Blank())->foo;
        
        return;
    }
    
    /**
     * __get() should throw OutOfBoundsException if property is not visible
     */
    public function test___get_throwsOutOfBoundsException_ifPropertyIsNotVisible()
    {
        $this->setExpectedException('OutOfBoundsException');
        
        // the "foo" property of the Foo class is protected
        // it should not be visible to the EntityTest class
        //
        (new Foo())->foo;
        
        return;
    }
    
    /**
     * __get() should return value if property is visible
     */
    public function test___get_returnsValue_ifPropertyIsVisible()
    {
        $foo  = new Foo();
        $open = new Open();
        
        $foo->attach($open);
        
        $this->assertEquals('open', $foo->open);
        
        return;
    }
    

    
    /* !__isset() */
    
    /**
     * __isset() should return false if the property does not exist
     */
    public function test___isset_returnsFalse_ifPropertyDoesNotExist()
    {
        $blank = new Blank();
        
        $this->assertFalse(isset($blank->foo));
        
        return;
    }

    /**
     * __isset() should return false if the property is not visible
     */
    public function test___isset_returnsFalse_ifPropertyIsNotVisible()
    {
        $foo = new Foo();
        $bar = new Bar();
        
        $foo->attach($bar);
        
        // bar is a protected property of the Bar object
        $this->assertFalse(isset($foo->bar));
        
        return;
    }
    
    /**
     * __isset() should return false if the property is null
     */
    public function test___isset_returnsFalse_ifPropertyIsNull()
    {
        $foo  = new Foo();
        $open = new Open();
        
        $foo->attach($open);
        
        // "null" is a public property of the Open class that has a null value
        // keep in mind, $foo->null would raise a syntax error
        //
        $this->assertFalse(isset($foo->{"null"}));
        
        return;
    }
    
    /**
     * __isset() should return true if the property is not null
     */
    public function test___isset_returnsTrue_ifPropertyIsNotNull()
    {
        $foo  = new Foo();
        $open = new Open();
        
        $foo->attach($open);
        
        // "open" is a public property of the Open class that has a string value
        $this->assertTrue(isset($foo->open));
        
        return;
    }
    
    
    /* !__set() */
    
    /**
     * __set() should throw OutOfBoundsException if the property does not exist
     */
    public function test___set_throwsOutOfBoundsException_ifPropertyDoesNotExist()
    {
        $this->setExpectedException('OutOfBoundsException');
        
        $blank = new Blank();
        
        $blank->foo = 'foo';
        
        return;
    }
    
    /**
     * __set() should throw OutOfBoundsException if the property is not visible
     */
    public function test___set_throwsOutOfBoundsException_ifPropertyIsNotVisible()
    {
        $this->setExpectedException('OutOfBoundsException');
        
        $foo = new Foo();
        
        $foo->foo = 'bar';
        
        return;
    }
    
    
    /**
     * __set() should return void if the property is visible
     */
    public function test___set_returnsNull_ifPropertyIsVisible()
    {
        $foo  = new Foo();
        $open = new Open();
        
        $foo->attach($open);
        
        $this->assertEquals('open', $foo->open);
        
        $foo->open = 'foo';
        
        $this->assertEquals('foo', $foo->open);
        
        return;
    }
    
    
    /* !__unset() */
    
    /*
     * Hmmm, I'm not sure how to test this method if the property does not exist or
     * is not visible. PHP does not allow unset()'s return value to be passed as an 
     * argument to a function or assigned to a variable. And, since the property does
     * not exist, I can't very well check to see if it was set to null.
     */
    
    /**
     * __unset() should return null if the property does not exist
     */
    /*
    public function test___unset_returnsNull_ifPropertyDoesNotExist()
    {
        $blank = new Blank();
        
        $this->assertNull(unset($blank->foo));
        
        return;
    }
    */
    
    /**
     * __unset() should return null if the property is not visible
     *
     * Hmmm, same problem as describe above.
     */
    /*
    public function test___unset_returnsNull_ifPropertyIsNotVisible()
    {
        $foo = new Foo();
        $bar = new Bar();
        
        $foo->attach($bar);
        
        $this->assertNull(unset($foo->bar));
        
        return;
    }
    */
    
    /**
     * __unset() should return null if the property is visible
     */
    public function test___unset_returnsNull_ifPropertyIsVisible()
    {
        $foo  = new Foo();
        $open = new Open();
        
        $foo->attach($open);
        
        // the "open" property's default value is the string "open"
        unset($foo->open);
        
        $this->assertNull($foo->open);
        
        return;
    }
    
    
    /* !attach() */
    
    /**
     * attach() should throw an InvalidArgumentException if a required method is 
     *     missing
     */
    public function test_attach_throwsInvalidArgumentException_ifRequiredMethodMissing()
    {
        $this->setExpectedException('InvalidArgumentException');
        
        (new Blank())->attach(new Required());
        
        return;
    }
    
    /**
     * attach() should throw an InvalidArgumentException if a required property is 
     *     missing
     */
    public function test_attach_throwsInvalidArgumentException_ifRequiredPropertyMissing()
    {
        $this->setExpectedException('InvalidArgumentException');
        
        (new Blank())->attach(new Required());
        
        return;
    }
    
    /**
     * attach() should throw an InvalidArgumentException if one or more properties
     *     collide
     * @group  foo
     */
    public function test_attach_throwsInvalidArgumentException_ifPropertiesCollide()
    {
        $this->setExpectedException('InvalidArgumentException');
        
        (new Foo())->attach(new FooPropertyCollision());
     
        return;
    }
    
    /**
     * attach() should throw an InvalidArgumentException if one or more methods 
     *     collide
     */
    public function test_attach_throwsInvalidArgumentException_ifMethodsCollide()
    {
        $this->setExpectedException('InvalidArgumentException');
        
        (new Foo())->attach(new FooMethodCollision());
        
        return;
    }
    
    /**
     * attach() should return self if source object is empty
     */
    public function test_attach_returnsSelf_ifObjectIsEmpty()
    {
        $foo   = new Foo();
        $blank = new Blank();
        
        $this->assertSame($foo, $foo->attach($blank));
        
        $this->assertEquals(
            [
                'getFoo' => new RefractionMethod($foo, 'getFoo'),
                'setFoo' => new RefractionMethod($foo, 'setFoo')  
            ],
            $foo->getMethods()
        );
        
        $this->assertEquals(
            [
                'foo' => new RefractionProperty($foo, 'foo')
            ],
            $foo->getProperties()
        );
        
        return;
    }
    
    /**
     * attach() should return self if source object is not empty
     */
    public function test_attach_returnsSelf_ifObjectIsNotEmpty()
    {
        $foo = new Foo();
        $bar = new Bar();
        
        $this->assertSame($foo, $foo->attach($bar));
        
        $this->assertEquals(
            [
                'getFoo' => new RefractionMethod($foo, 'getFoo'),
                'setFoo' => new RefractionMethod($foo, 'setFoo'),
                'getBar' => new RefractionMethod($bar, 'getBar'),
                'setBar' => new RefractionMethod($bar, 'setBar')
            ],
            $foo->getMethods()
        );    
        
        $this->assertEquals(
            [
                'foo' => new RefractionProperty($foo, 'foo'),
                'bar' => new RefractionProperty($bar, 'bar')
            ],
            $foo->getProperties()
        );
    
        return;
    }
    
    
    /* !detach() */
    
    /**
     * detach() should return self if object is empty
     */
    public function test_detach_returnsSelf_ifObjectIsEmpty()
    {
        $foo   = new Foo();
        $blank = new Blank();
        
        $this->assertSame($foo, $foo->detach($blank));
        
        $this->assertEquals(
            [
                'getFoo' => new RefractionMethod($foo, 'getFoo'),
                'setFoo' => new RefractionMethod($foo, 'setFoo')  
            ],
            $foo->getMethods()
        );
        
        $this->assertEquals(
            [
                'foo' => new RefractionProperty($foo, 'foo')
            ],
            $foo->getProperties()
        );
        
        return;
    }
    
    /**
     * detach() should return self if object is not attached
     */
    public function test_detach_returnsSelf_ifObjectIsNotAttached()
    {
        $foo = new Foo();
        $bar = new Bar();
        
        $this->assertSame($foo, $foo->detach($bar));
        
        $this->assertEquals(
            [
                'getFoo' => new RefractionMethod($foo, 'getFoo'),
                'setFoo' => new RefractionMethod($foo, 'setFoo')  
            ],
            $foo->getMethods()
        );
        
        $this->assertEquals(
            [
                'foo' => new RefractionProperty($foo, 'foo')
            ],
            $foo->getProperties()
        );
        
        return;
    }
    
    /**
     * detach() should return self if object is attached
     *
     * @group  bar
     */
    public function test_detach_returnsSelf_ifObjectIsAttached()
    {
        $foo = new Foo();
        $bar = new Bar();
        
        $foo->attach($bar);
        
        $this->assertSame($foo, $foo->detach($bar));
        
        $this->assertEquals(
            [
                'getFoo' => new RefractionMethod($foo, 'getFoo'),
                'setFoo' => new RefractionMethod($foo, 'setFoo')  
            ],
            $foo->getMethods()
        );
        
        $this->assertEquals(
            [
                'foo' => new RefractionProperty($foo, 'foo')
            ],
            $foo->getProperties()
        );
        
        return;
    }
    
    
    /* !getMethods() */
    
    /**
     * getMethods() should return array if methods do not exist
     */
    public function test_getMethods_returnsArray_ifMethodsDoNotExist()
    {
        return $this->assertEquals([], (new Blank())->getMethods());
    
    }
    
    /**
     * getMethods() should return array if defined methods exist
     */
    public function test_getMethods_returnsArray_ifMethodsDoExist()
    {
        // create a new Foo, Bar, and Baz
        $foo = new Foo();
        $bar = new Bar();
        $baz = new Baz();
        
        // attach baz to bar and attach bar to foo
        $bar->attach($baz);
        $foo->attach($bar);
        
        // set expectations
        $expected = [
            'getFoo' => new RefractionMethod($foo, 'getFoo'), 
            'setFoo' => new RefractionMethod($foo, 'setFoo'),
            'getBar' => new RefractionMethod($bar, 'getBar'),
            'setBar' => new RefractionMethod($bar, 'setBar'),
            'getBaz' => new RefractionMethod($baz, 'getBaz'),
            'setBaz' => new RefractionMethod($baz, 'setBaz')
        ];
        
        // get the actual methods
        $actual = $foo->getMethods();
        
        $this->assertEquals($expected, $actual);
        
        return;
    }
    
    
    /* !getRequiredMethods() */
    
    /**
     * getRequiredMethods() should return an array if requirements do not exist
     */
    public function test_getRequiredMethods_returnsArray_ifRequirementsDoNotExist()
    {
        return $this->assertEquals([], (new Blank())->getRequiredMethods());
    }
    
    /**
     * getRequiredMethods() should return an array if requirements do exist
     */
    public function test_getRequiredMethods_returnsArray_ifRequirementsDoExist()
    {
        return $this->assertEquals(['foo'], (new Required())->getRequiredMethods());    
    }
    
    
    /* !getRequiredProperties() */
    
    /**
     * getRequiredProperties() should return an array if requirements do not exist
     */
    public function test_getRequiredProperties_returnsArray_ifRequirementsDoNotExist()
    {
        return $this->assertEquals([], (new Blank())->getRequiredProperties());
    }
    
    /**
     * getRequiredProperties() should return an array if requirements do exist
     */
    public function test_getRequiredProperties_returnsArray_ifRequirementsDoExist()
    {
        return $this->assertEquals(['bar'], (new Required())->getRequiredProperties());
    }
    
    
    /* !getProperties() */   
    
    /**
     * getProperties() should return array if properties do not exist
     */
    public function test_getProperties_returnsArray_ifPropertiesDoNotExist()
    {
        return $this->assertEquals([], (new Blank())->getProperties());
    }
    
    /**
     * getProperties() should return array if properties do exist
     */
    public function test_getProperties_returnsArray_ifPropertiesDoExist()
    {
        // create a new Foo, Bar, and Baz
        $foo = new Foo();
        $bar = new Bar();
        $baz = new Baz();
        
        // attach baz to bar and bar to foo
        $bar->attach($baz);
        $foo->attach($bar);
        
        // set expectations
        $expected = [
            'foo' => new RefractionProperty($foo, 'foo'),
            'bar' => new RefractionProperty($bar, 'bar'),
            'baz' => new RefractionProperty($baz, 'baz') 
        ]; 
        
        // get the actual properties
        $actual = $foo->getProperties();
        
        $this->assertEquals($expected, $actual);
        
        return;
    }
}

