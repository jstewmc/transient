<?php
/**
 * The file for the method declaration error class
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2015 Jack Clayton
 * @license    MIT
 */
namespace Jstewmc\Transient\Tests\Classes\Error;

/**
 * A method declaration error test class
 *
 * @since  0.1.0
 */
class MethodRedeclaration extends \Jstewmc\Transient\Entity
{
    public function getFoo()
    {
        return;
    }
}
