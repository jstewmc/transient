<?php
/**
 * The file for the Baz test class
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2015 Jack Clayton
 * @license    MIT
 */
namespace Jstewmc\Transient\Tests\Classes;

/**
 * A Baz test class
 *
 * @since  0.1.0
 */
class Baz extends \Jstewmc\Transient\Entity
{
    protected $baz = 'baz';
    
    public function getBaz()
    {
        return $this->baz;
    }

    public function setBaz($baz)
    {
        $this->baz = $baz;
        
        return $this;
    }
}
