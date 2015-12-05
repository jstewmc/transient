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
 * A property not found exception is thrown when a property is undefined.
 *
 * @since  0.1.0
 */
class Property extends NotFound
{   
    /* !Magic methods */
    
    /**
     * Called when the exception is constructed
     *
     * @param  string[]  $properties  the exception's properties
     * @return  self
     * @throws  InvalidArgumentException  if $names is neither a string nor array
     * @since  0.1.0
     */
    public function __construct($names)
    {
        parent::__construct($names);
        
        if (count($this->names) === 1) {
            $this->message = "Property {$this->names[0]} could not be found";
        } else {
            $this->message = "The following properties could not be found: "
                .implode(', ', $this->names);
        }
        
        return;
    }   
}
