<?php
/**
 * The file for the Bar test class
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2015 Jack Clayton
 * @license    MIT
 */
namespace Jstewmc\Transient\Tests\Classes;

/**
 * A Bar test class
 *
 * @since  0.1.0
 */
class Bar extends \Jstewmc\Transient\Entity
{
    protected $bar = 'bar';
    
    public function getBar()
    {
        return $this->bar;
    }

    public function setBar($bar)
    {
        $this->bar = $bar;
        
        return $this;
    }
}
