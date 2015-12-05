<?php
/**
 * The file for the method not found exception test class
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2015 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Transient\Exception\NotFound;

/**
 * The method not found exception test class
 *
 * @since  0.1.0
 */
class MethodTest extends \PHPUnit_Framework_TestCase
{
    /* !__construct() */
    
    /**
     * __construct() should throw an InvalidArgumentException if $names is not a 
     *     string or array
     */
    public function test___construct_throwsInvalidArgumentException_ifNamesNotStringOrArray()
    {
        $this->setExpectedException('InvalidArgumentException');
        
        new Method(999);
    }
    
    /**
     * __construct() should set the exception's names and message if names is array
     */
    public function test___construct_returnsSelf_ifNamesIsArray()
    {
        $names = ['foo', 'bar'];
        
        $e = new Method($names);
        
        $this->assertEquals($names, $e->getNames());
        $this->assertEquals(
            'The following methods could not be found: foo, bar',
            $e->getMessage()
        );
        
        return;
    }
    
    /**
     * __construct() should set the exception's names and message if names is string
     */
    public function test___construct_returnsSelf_ifNamesIsString()
    {
        $name = 'foo';
        
        $e = new Method($name);
        
        $this->assertEquals([$name], $e->getNames());
        $this->assertEquals("Method $name could not be found", $e->getMessage());

        return;
    }
    
    
    
    /* !getNames() */
    
    /**
     * getMethods() should return array
     */
    public function test_getNames_returnsArray()
    {
        return $this->assertEquals(['foo'], (new Method(['foo']))->getNames());
    }
}
