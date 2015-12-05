<?php
/**
 * The file for the not found exception class
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2015 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Transient\Exception\NotFound;

/**
 * A not found exception
 *
 * A not found exception is thrown when a method or property is undefined. For 
 * example, a not found exception will be thrown when a destination entity is missing 
 * a source entity's required method or property.
 *
 * Keep in mind, unlike a *redeclaration* exception, a *not found* exception only has 
 * a method or property name, not a refraction object.
 *
 * @since  0.1.0
 */
abstract class NotFound extends \Jstewmc\Transient\Exception\Exception
{
    /* !Protected properties */
    
    /**
     * @var  string[]  the exception's method or property names
     * @since  0.1.0
     */
    protected $names = [];     
    
    
    /* !Get methods */
    
    /**
     * Returns the exception's method or property names
     *
     * @return  string[]  
     * @since   0.1.0
     */
    public function getNames()
    {
        return $this->names;
    }
    
    
    /* !Magic methods */
    
    /**
     * Called when the object is constructed
     *
     * @param  string|string[]  $names  a method or property name or an array of 
     *     method or property names
     * @return  self
     * @throws  InvalidArgumentException  if $names is not a string or array
     * @since   0.1.0
     */
    public function __construct($names)
    {
        if ( ! is_string($names) && ! is_array($names)) {
            throw new \InvalidArgumentException(
                __METHOD__."() expects parameter one, names, to be a string name "
                    . "or an array of names"
            );    
        }
        
        $this->names = (array) $names;
        
        return;
    }
}
