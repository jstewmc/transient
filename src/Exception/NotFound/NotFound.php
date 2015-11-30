<?php
/**
 * The file for the not found exception class
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2015 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Transient\Exception\NotFound;

/**
 * A not found exception
 *
 * A undefined exception is thrown when a method or property cannot be found. For 
 * example, a not found exception will be thrown when a destination entity is missing 
 * a source entity's required method or property.
 *
 * Keep in mind, unlike a *redeclaration* exception, a *not found* exception only has 
 * a method or property name, not refraction object.
 *
 * @since  0.1.0
 */
abstract class NotFound extends \Jstewmc\Transient\Exception\Exception
{
    // nothing yet
}
