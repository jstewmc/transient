<?php
/**
 * The file for the method not found exception class
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2015 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Transient\Exception\NotFound;

/**
 * A method not found exception
 *
 * @since  0.1.0
 */
class Method extends NotFound
{
    /* !Protected properties */
    
    /**
     * @var    string  the method's name
     * @since  0.1.0
     */
    protected $name;
    
    
    /* !Get methods */
    
    /**
     * Returns the exception's method name
     *
     * @erturn  string  the method's name
     * @since  0.1.0
     */
    public function getName()
    {
        return $this->name;
    }
    
    
    /* !Magic methods */
    
    /**
     * Called when the exception is constructed
     *
     * @param  string  $name  the method's name
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
        $this->message = "Method $name() could not be found";
        
        return;
    }
}
