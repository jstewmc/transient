<?php
/**
 * The file for the Quux class
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2015 Jack Clayton
 * @license    MIT
 */
namespace Jstewmc\Transient\Tests;

/**
 * An open test class
 *
 * @since  0.1.0
 */
class Open extends \Jstewmc\Transient\Entity
{
    public $open = 'open';
    
    public $null = null;
    
    public function getOpen()
    {
        return $this->open;
    }

    public function setOpen($open)
    {
        $this->open = $open;
        
        return $this;
    }
}
