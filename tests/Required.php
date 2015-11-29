<?php
/**
 * The file for the Required class
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2015 Jack Clayton
 * @license    MIT
 */
namespace Jstewmc\Transient\Tests;

/**
 * A Required test class
 *
 * @since  0.1.0
 */
class Required extends \Jstewmc\Transient\Entity
{
    protected static $requiredMethods = ['foo'];
    
    protected static $requiredProperties = ['bar'];
}
