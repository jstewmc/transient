<?php
/**
 * The file for the properties redeclaration exception test class
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2015 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Transient\Exception\Redeclaration;

use Jstewmc\Refraction\RefractionProperty;

use Jstewmc\Transient\Tests\Classes\Foo;

/**
 * The properties redeclaration exception test class
 *
 * @since  0.1.0
 */
class PropertiesTest extends \PHPUnit_Framework_TestCase
{
    /* !__construct() */
    
    /**
     * __construct() should set properties and message
     */
    public function test___construct()
    {
        $foo = new Foo();
        
        $properties = [new RefractionProperty($foo, 'foo')];
        
        $e = new Properties($properties);
        
        $this->assertSame($properties, $e->getProperties());
        $this->assertEquals(
            'Cannot redeclare the following properties: '
                . 'Jstewmc\Transient\Tests\Classes\Foo::foo',
            $e->getMessage()
        );
        
        return;
    }
    
    
    /* !getProperties() */
    
    /**
     * getProperties() should return array
     */
    public function test_getProperties()
    {
        $foo = new Foo();
        
        $properties = [new RefractionProperty($foo, 'foo')];
        
        $this->assertSame(
            $properties, 
            (new Properties($properties))->getProperties()
        );
        
        return;
    }
}
