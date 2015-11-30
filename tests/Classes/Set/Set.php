<?php
/**
 * The file for the set test class
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2015 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Transient\Tests\Classes\Set;

/**
 * The set test class
 *
 * The set test class has a public property with a value and a public property with
 * a null value.
 *
 * @since  0.1.0
 */
class Set extends \Jstewmc\Transient\Entity
{
    public $notNull = 'notNull';
    
    public $null = null;
}
