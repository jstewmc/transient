<?php
/**
 * The file for the methods redeclaration exception test class
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2015 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Transient\Exception\Redeclaration;

use Jstewmc\Refraction\RefractionMethod;

use Jstewmc\Transient\Tests\Foo;

/**
 * The methods redeclaration exception test class
 *
 * @since  0.1.0
 */
class MethodsTest extends \PHPUnit_Framework_TestCase
{
    /* !__construct() */
    
    /**
     * __construct() should set methods and message
     */
    public function test___construct()
    {
        $foo = new Foo();
        
        $methods = [
            new RefractionMethod($foo, 'getFoo'),
            new RefractionMethod($foo, 'setFoo')
        ];
        
        $e = new Methods($methods);
        
        $this->assertSame($methods, $e->getMethods());
        $this->assertEquals(
            'Cannot redeclare the following methods: '
                . 'Jstewmc\Transient\Tests\Foo::getFoo() and '
                . 'Jstewmc\Transient\Tests\Foo::setFoo()',
            $e->getMessage()
        );
        
        return;
    }
    
    
    /* !getMethods() */
    
    /**
     * getMethods() should return array
     */
    public function test_getMethods()
    {
        $foo = new Foo();
        
        $methods = [
            new RefractionMethod($foo, 'getFoo'), 
            new RefractionMethod($foo, 'setFoo')
        ];
        
        $this->assertEquals($methods, (new Methods($methods))->getMethods());
        
        return;
    }
}
