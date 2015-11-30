<?php
/**
 * The file for the method not found exception
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2015 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Transient\Exception\NotFound;

/**
 * The method not found exception class
 *
 * @since  0.1.0
 */
class MethodTest extends \PHPUnit_Framework_TestCase
{
    /* !__construct() */
    
    /**
     * __construct should set the name and the message
     */
    public function test___construct()
    {
        $name = 'foo';
        
        $e = new Method($name);
        
        $this->assertEquals($name, $e->getName());
        $this->assertEquals('Method foo() could not be found', $e->getMessage());
        
        return;
    }
    
    
    /* !getName() */
    
    /**
     * getName() should return string if name does exist
     */
    public function test_getName()
    {
        return $this->assertEquals('foo', (new Method('foo'))->getName());
    }
}
