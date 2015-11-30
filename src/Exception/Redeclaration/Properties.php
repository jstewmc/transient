<?php
/**
 * The file for the properties redeclaration exception class
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2015 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Transient\Exception\Redeclaration;

/**
 * A properties redeclaration exception
 *
 * @since  0.1.0
 */
class Properties extends Redeclaration
{
    /* !Protected properties */
    
    /**
     * @var  Jstewmc\Refraction\RefractionProperty[]  the exception's properties
     * @since  0.1.0
     */
    protected $properties = [];
    
    
    /* !Get methods */
    
    /**
     * Returns the exception's properties
     *
     * @return  Jstewmc\Refraction\RefractionProperty[]
     * @since   0.1.0
     */
    public function getProperties()
    {
        return $this->properties;
    }
    
    
    /* !Set methods */
    
    /**
     * Sets the exception's properties
     *
     * @param  Jstewmc\Refraction\RefractionProperty[]  $properties
     * @return  self
     * @since   0.1.0
     */
    public function setProperties(Array $properties)
    {
        $this->properties = $properties;
        
        return $this;
    }
    
    
    /* !Magic methods */
    
    /**
     * Called when the object is constructed
     *
     * @param  Jstewmc\Refraction\RefractionProperty[]  $properties  the exception's
     *     properties
     * @return  self
     * @since   0.1.0
     */
    public function __construct(Array $properties)
    {
        $this->properties = $properties;
        $this->message = "Cannot redeclare the following properties: "
            . $this->listProperties();
        
        return;
    }
    
    
    /* !Protected methods */
    
    /**
     * Lists the properties as a human-readable string
     *
     * @return  string
     * @since   0.1.0
     */
    protected function listProperties()
    {
        $list = '';
        
        $names = [];
        foreach ($this->properties as $property) {
            $names[] = "{$property->class}::{$property->name}";
        }
        
        if (count($names) === 1) {
            $list = "{$names[0]}";
        } elseif (count($names) === 2) {
            $list = "{$names[0]} and {$names[1]}";
        } else {
            $list = implode(', ', $names);
        }
        
        return $list;
    }
}
