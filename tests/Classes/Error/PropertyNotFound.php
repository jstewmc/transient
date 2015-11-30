<?php
/**
 * The file for the property not found test class
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2015 Jack Clayton
 * @license    MIT
 */
namespace Jstewmc\Transient\Tests\Classes\Error;

/**
 * A property not found test class
 *
 * @since  0.1.0
 */
class PropertyNotFound extends \Jstewmc\Transient\Entity
{
    protected static $requiredProperties = ['qux'];
}
