<?php
/**
 * The file for the open visibility test class
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2015 Jack Clayton
 * @license    MIT
 */
namespace Jstewmc\Transient\Tests\Classes\Visibility;

/**
 * An open visibility test class
 *
 * An open visibility test class has public properties and methods.
 *
 * @since  0.1.0
 */
class Open extends \Jstewmc\Transient\Entity
{
    public $open = 'open';
    
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
