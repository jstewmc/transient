<?php
/**
 * The file for the FooUndefinedMethod class
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2015 Jack Clayton
 * @license    MIT
 */
namespace Jstewmc\Transient\Tests;

/**
 * A FooUndefinedMethod test class
 *
 * @since  0.1.0
 */
class FooUndefinedMethod extends \Jstewmc\Transient\Entity
{
    protected static $requiredMethods = ['bar'];
}
