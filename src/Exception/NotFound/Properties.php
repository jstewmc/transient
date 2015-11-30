<?php
/**
 * The file for the properties not found exception class
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2015 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Transient\Exception\NotFound;

/**
 * A properties not found exception
 *
 * @since  0.1.0
 */
class Properties extends NotFound
{
    /* !Protected properties */
    
    /**
     * @var  string[]  the exception's property names
     * @since  0.1.0
     */
    protected $properties = [];
    
    
    /* !Get methods */
    
    /**
     * Returns the exception's properties
     *
     * @return  string[]  the exception's properties
     * @since   0.1.0
     */
    public function getProperties()
    {
        return $this->properties;
    }
    
    
    /* !Magic methods */
    
    /**
     * Called when the exception is constructed
     *
     * @param  string[]  $properties  the exception's properties
     * @return  self
     * @since  0.1.0
     */
    public function __construct(Array $properties)
    {
        $this->properties = $properties;
        $this->message    = "The following properties could not be found: "
            . $this->listProperties();
        
        return;
    }
    
    
    /**
     * Lists property names as a human-friendly string
     *
     * @return  string
     * @sicnce  0.1.0
     */
    protected function listProperties()
    {
        $list = '';
        
        if (count($this->properties) === 1) {
            $list = "'{$this->properties[0]}'";
        } elseif (count($this->properties) === 2) {
            $list = "'{$this->properties[0]}' and '{$this->properties[1]}'";
        } else {
            $list = "'".implode(", '", $this->properties)."'";
        }
        
        return $list;
    }    
}
