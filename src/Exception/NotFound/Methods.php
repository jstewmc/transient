<?php
/**
 * The file for the methods not found exception
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2015 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Transient\Exception\NotFound;

/**
 * A methods not found exception
 *
 * @since  0.1.0
 */
class Methods extends NotFound
{
    /* !Protected properties */
    
    /**
     * @var  string[]  the exception's method names
     * @since  0.1.0
     */
    protected $methods = [];     
    
    
    /* !Get methods */
    
    /**
     * Returns the exception's method names
     *
     * @return  string[]  
     * @since   0.1.0
     */
    public function getMethods()
    {
        return $this->methods;
    }
    
    
    /* !Magic methods */
    
    /**
     * Called when the object is constructed
     *
     * @param  string[]  $methods  the exception's method names
     * @return  self
     * @since   0.1.0
     */
    public function __construct(Array $methods) 
    {
        $this->methods = $methods;
        $this->message = "The following methods could not be found: "
            . $this->listMethods();
        
        return;
    }
    
    
    /* !Protected methods */
    
    /**
     * Lists method names as a human-friendly string
     *
     * @return  string
     * @since   0.1.0
     */
    protected function listMethods()
    {
        $list = '';
        
        if (count($this->methods) === 1) {
            $list = "{$this->methods[0]}()";
        } elseif (count($this->methods) === 2) {
            $list = "{$this->methods[0]}() and {$this->methods[1]}()";
        } else {
            $list = implode('(), ', $this->methods).'()';
        }
        
        return $list;
    }
}
