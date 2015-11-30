<?php
/**
 * The file for the FooUndefinedProperty class
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2015 Jack Clayton
 * @license    MIT
 */
namespace Jstewmc\Transient\Tests;

/**
 * A FooUndefinedProperty test class
 *
 * @since  0.1.0
 */
class FooUndefinedProperty extends \Jstewmc\Transient\Entity
{
    protected static $requiredProperties = ['bar'];
}
