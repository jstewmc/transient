<?php
/**
 * The file for the property not found exception test class
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2015 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Transient\Exception\NotFound;

/**
 * The property not found exception test class
 *
 * @since  0.1.0
 */
class PropertyTest extends \PHPUnit_Framework_TestCase
{
    /* !__construct() */
    
    /**
     * __construct() should throw an InvalidArgumentException if $names is neither a
     *     string nor array
     */
    public function test___construct_throwsInvalidArgumentException_ifNamesIsNotStringOrArray()
    {
        $this->setExpectedException('InvalidArgumentException');
        
        new Property(999);
        
        return;
    }
    
    /**
     * __construct() should set the names and message if $names is an array
     */
    public function test___construct_returnsSelf_ifNamesIsArray()
    {
        $names = ['foo', 'bar'];
        
        $e = new Property($names);
        
        $this->assertEquals($names, $e->getNames());
        $this->assertEquals(
            "The following properties could not be found: foo, bar",
            $e->getMessage()
        );
        
        return;
    }
    
    /**
     * __construct() should set the names and message if $names is a string
     */
    public function test___construct_returnsSelf_ifNamesIsString()
    {
        $name = 'foo';
        
        $e = new Property($name);
        
        $this->assertEquals([$name], $e->getNames());
        $this->assertEquals("Property $name could not be found", $e->getMessage());
        
        return;
    }
    
    
    /* !getNames() */
    
    /**
     * getNames() should return array if names do exist
     */
    public function test_getNames()
    {
        return $this->assertEquals(['foo'], (new Property(['foo']))->getNames());
    }
}
