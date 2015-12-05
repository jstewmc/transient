<?php
/**
 * The file for the method redeclaration exception class
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2015 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Transient\Exception\Redeclaration;

/**
 * A method redeclaration exception
 *
 * @since  0.1.0
 */
class Method extends Redeclaration
{
    /* !Protected properties */
    
    /**
     * @var  Jstewmc\Refraction\RefractionMethod[]  the exception's methods
     * @since  0.1.0
     */
    protected $methods = [];
    
    
    /* !Get methods */
    
    /**
     * Returns the exception's methods
     *
     * @return  Jstewmc\Refraction\RefractionMethod[]
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
     * @param  Jstewmc\Refraction\RefractionMethod[]  $methods  the exception's
     *     methods
     * @return  self
     * @since   0.1.0
     */
    public function __construct(Array $methods)
    {
        $this->methods = $methods;
        $this->message = "Cannot redeclare the following methods: "
            . $this->listMethods();
        
        return;
    }
    
    
    /* !Protected methods */
    
    /**
     * Lists the methods as a human-readable string
     *
     * @return  string
     * @since   0.1.0
     */
    protected function listMethods()
    {
        $list = '';
        
        $names = [];
        foreach ($this->methods as $method) {
            $names[] = "{$method->class}::{$method->name}()";
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

