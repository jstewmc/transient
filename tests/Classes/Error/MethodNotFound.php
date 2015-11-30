<?php
/**
 * The file for the method not found test class
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2015 Jack Clayton
 * @license    MIT
 */
namespace Jstewmc\Transient\Tests\Classes\Error;

/**
 * A method not found test class
 *
 * The method not found test class should require a method that the Foo entity does
 * not have.
 *
 * @since  0.1.0
 */
class MethodNotFound extends \Jstewmc\Transient\Entity
{
    protected static $requiredMethods = ['qux'];
}
