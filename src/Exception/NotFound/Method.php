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
 * A method not found exception
 *
 * A method not found exception is thrown when one or methods cannot be found.
 *
 * @since  0.1.0
 */
class Method extends NotFound
{
    /* !Protected properties */
    
    /**
     * @var  string[]  the exception's method names
     * @since  0.1.0
     */
    protected $names = [];     
    
    
    /* !Get methods */
    
    /**
     * Returns the exception's method names
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
     * @param   string|string[]  $methods  the exception's method names
     * @return  self
     * @throws  InvalidArgumentException  if $methods is neither an array nor string
     * @since   0.1.0
     */
    public function __construct($names) 
    {
        if ( ! is_string($names) && ! is_array($names)) {
            throw new \InvalidArgumentException(
                __METHOD__."() expects parameter one, methods, to be a string method "
                    . "name or array of method names"
            );    
        }
        
        $this->names = (array) $names;
        
        if (count($names) === 1) {
            $this->message = "Method {$this->names[0]} could not be found";
        } else {
            $this->message = "The following methods could not be found: "
                .implode(', ', $this->names);
        }
        
        return;
    }
}
