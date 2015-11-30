<?php
/**
 * The file for the property required test class
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2015 Jack Clayton
 * @license    MIT
 */
namespace Jstewmc\Transient\Tests\Classes\Required;

/**
 * A property required test class
 *
 * @since  0.1.0
 */
class Property extends \Jstewmc\Transient\Entity
{
    protected static $requiredProperties = ['requiredProperty'];
}
