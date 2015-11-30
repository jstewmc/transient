<?php
/**
 * The file for the method required test class
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2015 Jack Clayton
 * @license    MIT
 */
namespace Jstewmc\Transient\Tests\Classes\Required;

/**
 * A method required test class
 *
 * @since  0.1.0
 */
class Method extends \Jstewmc\Transient\Entity
{
    protected static $requiredMethods = ['requiredMethod'];
}
