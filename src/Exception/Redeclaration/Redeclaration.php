<?php
/**
 * The file for the redeclaration exception class
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2015 Jack Clayton 
 * @license    MIT
 */

namespace Jstewmc\Transient\Exception\Redeclaration;

/**
 * A redeclaration exception
 *
 * A redeclaration exception is thrown when the user attempts to redeclare a property 
 * or method. For example, a defined exception will be thrown when a destination
 * entity and a source entity have a method or property name in common.
 *
 * Keep in mind, unlike an *not found* exception, a *redeclaration* exception has the 
 * method or property as a refraction object, not just a string name.
 *
 * @since  0.1.0
 */
abstract class Redeclaration extends \Jstewmc\Transient\Exception\Exception
{
    // nothing yet    
} 
