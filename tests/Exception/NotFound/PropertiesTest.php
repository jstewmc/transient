<?php
/**
 * The file for the properties not found exception test class
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2015 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Transient\Exception\NotFound;

/**
 * The properties not found exception test class
 *
 * @since  0.1.0
 */
class PropertiesTest extends \PHPUnit_Framework_TestCase
{
    /* !__construct() */
    
    /**
     * __construct() should set the exception's properties and message
     */
    public function test___construct()
    {
        $properties = ['foo', 'bar'];
        
        $e = new Properties($properties);
        
        $this->assertEquals($properties, $e->getProperties());
        $this->assertEquals(
            "The following properties could not be found: 'foo' and 'bar'",
            $e->getMessage()
        );
        
        return;
    }
    
    
    /* !getProperties() */
    
    /**
     * getProperties() should return array if properties do exist
     */
    public function test_getProperties()
    {
        return $this->assertEquals(
            ['foo'], 
            (new Properties(['foo']))->getProperties()
        );
    }
}
