<?php
/**
 * The file for the methods not found exception test class
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2015 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Transient\Exception\NotFound;

/**
 * The methods not found exception test class
 *
 * @since  0.1.0
 */
class MethodsTest extends \PHPUnit_Framework_TestCase
{
    /* !__construct() */
    
    /**
     * __construct() should set the exception's methods and message
     */
    public function test___construct()
    {
        $methods = ['foo', 'bar'];
        
        $e = new Methods($methods);
        
        $this->assertEquals($methods, $e->getMethods());
        $this->assertEquals(
            'The following methods could not be found: foo() and bar()',
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
        return $this->assertEquals(['foo'], (new Methods(['foo']))->getMethods());
    }
}
