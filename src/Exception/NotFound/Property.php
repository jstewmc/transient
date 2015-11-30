<?php
/**
 * The file for the property not found exception class
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2015 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Transient\Exception\NotFound;

/**
 * A property not found exception
 *
 * @since  0.1.0
 */
class Property extends NotFound
{
    /* !Protected properties */
    
    /**
     * @var    string  the property's name
     * @since  0.1.0
     */
    protected $name;
    
    
    /* !Get propertys */
    
    /**
     * Returns the exception's property name
     *
     * @erturn  string  the property's name
     * @since  0.1.0
     */
    public function getName()
    {
        return $this->name;
    }
    
    
    /* !Magic propertys */
    
    /**
     * Called when the exception is constructed
     *
     * @param  string  $name  the property's name
     * @return  self
     * @throws  InvalidArgumentException  if $name is not a string
     * @since   0.1.0
     */
    public function __construct($name)
    {
        if ( ! is_string($name)) {
            throw new \InvalidArgumentException(
                __METHOD__."() expects parameter one, name, to be a string"
            );
        }
        
        $this->name    = $name;
        $this->message = "Property '$name' could not be found";
        
        return;
    }
}
