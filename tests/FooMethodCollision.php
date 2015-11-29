<?php
/**
 * The file for the FooMethodCollision class
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2015 Jack Clayton
 * @license    MIT
 */
namespace Jstewmc\Transient\Tests;

/**
 * A FooMethodCollision test class
 *
 * @since  0.1.0
 */
class FooMethodCollision extends \Jstewmc\Transient\Entity
{
    public function getFoo()
    {
        return;
    }
}
