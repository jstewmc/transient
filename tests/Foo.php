<?php
/**
 * The file for the Foo class
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2015 Jack Clayton
 * @license    MIT
 */
namespace Jstewmc\Transient\Tests;

/**
 * A Foo test class
 *
 * @since  0.1.0
 */
class Foo extends \Jstewmc\Transient\Entity
{
    protected $foo = 'foo';
    
    public function getFoo()
    {
        return $this->foo;
    }

    public function setFoo($foo)
    {
        $this->foo = $foo;
        
        return $this;
    }
}
