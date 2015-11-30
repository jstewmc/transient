<?php
/**
 * The file for the closed visiblity class
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2015 Jack Clayton
 * @license    MIT
 */
namespace Jstewmc\Transient\Tests\Classes\Visibility;

/**
 * A closed test class
 *
 * A closed test class has private or protected properties and methods.
 *
 * @since  0.1.0
 */
class Closed extends \Jstewmc\Transient\Entity
{
    protected $closed = 'closed';
    
    protected function getClosed()
    {
        return $this->closed;
    }

    protected function setClosed($closed)
    {
        $this->closed = $closed;
        
        return $this;
    }
}
