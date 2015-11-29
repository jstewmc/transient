<?php
/**
 * The file for the Entity class
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2015 Jack Clayton
 * @license    MIT
 */
    
namespace Jstewmc\Transient;

use Jstewmc\Refraction\RefractionClass;
use Jstewmc\Refraction\RefractionMethod;
use Jstewmc\Refraction\RefractionProperty;

/**
 * A transient entity
 *
 * A transient entity can attach its methods and properties to other transient 
 * entities, and the combination will behave as if they were the same object. 
 *
 * There are a few caveats:
 *
 *     - An entity MUST have unique method and property names. 
 *     - An entity MUST NOT override the base methods or properties. 
 *
* @since  0.1.0
 */
abstract class Entity
{
    /* !Protected properties */
    
    /**
     * @var  string[]  an array of methods names that must be present in the 
     *     destination entity for this entity to be attached (regardless of 
     *     visibility) (case-insensitive)
     * @since  0.1.0
     */
    protected static $requiredMethods = [];
    
    /**
     * @var  string[]  an array of property names that must be present in the 
     *     destination entity for this entity to be attached (regardless of 
     *     visibility) (case-sensitive)
     * @since  0.1.0
     */
    protected static $requiredProperties = [];
    
    /**
     * @var  RefractionMethod[]  the entity's transient methods, indexed by method 
     *     name
     * @since  0.1.0
     */
    protected $transientMethods = [];
    
    /**
     * @var  RefractionProperty[]  the entity's transient properties, indexed by
     *     property name
     * @since  0.1.0
     */
    protected $transientProperties = [];
    
    
    /* !Get methods */
    
    /**
     * Returns the entity's required methods
     *
     * @return  string[]  the entity's required methods
     * @since   0.1.0
     */
    final public function getRequiredMethods()
    {
        return static::$requiredMethods;
    }
    
    /**
     * Returns the entity's required properties
     *
     * @return  string[]  the entity's required properties
     * @since   0.1.0
     */
    final public function getRequiredProperties()
    {
        return static::$requiredProperties;
    }
    
    
    /* !Magic methods */
    
    /**
     * Called when a method is inaccessible
     *
     * @param   string   $name       the method's name
     * @param   mixed[]  $arguments  the method's arguments
     * @return  mixed
     * @throws  BadMethodCallException  if method does not exist
     * @throws  BadMethodCallException  if method is not visible to calling class
     * @since   0.1.0
     */
    public function __call($name, $arguments)
    {
        // if the transient method does not exist, short-circuit
        if ( ! array_key_exists($name, $this->transientMethods)) {
            throw new \BadMethodCallException(
                "Method $name() does not exist, neither as a defined method nor as "
                    . "a transient method"
            );
        }
        
        // get the transient method
        $method = $this->transientMethods[$name];
        
        // get the method's calling class
        $class = $this->getCallingClass();
        
        // if the method is not visible to the class, short-circuit
        if ( ! $this->isMethodVisible($method, $class)) {
            throw new \BadMethodCallException(
                "Method $name() does exists, but it is not visible to the calling "
                    . "class, ".get_class($class)
            );
        }
       
        // otherwise, get the method as a closure
        $closure = $method->getClosure();
        
        // bind the closure to this object and its scope
        $closure = $closure->bindTo($this, $this);
        
        // call the closure
        $result = call_user_func_array($closure, $arguments);
        
        return $result;
    }
    
    /**
     * Called when reading an inaccesible property
     *
     * @param   string  $name  the property's name
     * @return  mixed
     * @throws  OutOfBoundsException  if the property does not exist
     * @throws  OutOfBoundsException  if the property is not visible to calling class
     * @since   0.1.0
     */
    public function __get($name)
    {
        // if the transient property does not exist, short-circuit
        if ( ! array_key_exists($name, $this->transientProperties)) {
            throw new \OutOfBoundsException(
                "Property '$name' does not exist, neither as a defined property nor "
                    . "as a transient property"
            );
        }
        
        // get the property
        $property = $this->transientProperties[$name];
        
        // get the property's calling class
        $class = $this->getCallingClass();
        
        // if the property is not visible to the calling class, short-circuit
        if ( ! $this->isPropertyVisible($property, $class)) {
            throw new \OutOfBoundsException(
                "Property '$name' does exist, but it is not visible to the calling "
                    . "class, ".get_class($class)
            );
        }
        
        // otherwise, get the property's value
        $value = $property->get();
        
        return $value;
    }
    
    /**
     * Called when isset() or empty() is called on inaccessible property
     *
     * @param   string  $name  the property's name
     * @return  bool
     * @since   0.1.0
     */
    public function __isset($name)
    {
        $isset = false;
        
        // if the property exists
        if (array_key_exists($name, $this->transientProperties)) {
            // get the property
            $property = $this->transientProperties[$name];
            // get the property's calling class
            $class = $this->getCallingClass();
            // if the property is visible to the calling class
            if ($this->isPropertyVisible($property, $class)) {
                // if the property is not null
                if ($property->get() !== null) {
                    // great success!
                    $isset = true;
                }
            }
        }
        
        return $isset;
    }
    
    /**
     * Called when writing to an inaccessible property
     *
     * @param   string  $name   the property's name
     * @param   mixed   $value  the property's value
     * @return  void
     * @since   0.1.0
     */
    public function __set($name, $value)
    {
        // if the transient property does not exist, short-circuit
        if ( ! array_key_exists($name, $this->transientProperties)) {
            throw new \OutOfBoundsException(
                "Property '$name' does not exist, neither as a defined property nor "
                    . "as a transient property"
            );
        }
        
        // get the property
        $property = $this->transientProperties[$name];
        
        // get the property's calling class
        $class = $this->getCallingClass();
        
        // if the property is not visible to the calling class, short-circuit
        if ( ! $this->isPropertyVisible($property, $class)) {
            throw new \OutOfBoundsException(
                "Property '$name' does exist, but it is not visible to the calling "
                    . "class, ".get_class($class)
            );
        }
        
        // otherwise, set the property's value
        $property->set($value);
        
        return;
    }
    
    /**
     * Called when __unset() is called on an inaccessible property
     *
     * @param   string  $name  the property's name
     * @return  bool
     * @since   0.1.0
     */
    public function __unset($name)
    {
        // if the property exists
        if (array_key_exists($name, $this->transientProperties)) {
            // get the property
            $property = $this->transientProperties[$name];
            // get the property's calling class
            $class = $this->getCallingClass();
            // if the property is visible
            if ($this->isPropertyVisible($property, $class)) {
                // set the property's value to null
                $property->set(null);
            }
        }
        
        return;
    }
    
    
    /* !Public methods */
    
    /**
     * Attaches an object to the entity
     *
     * Keep in mind, I'm atomic. I will either attach *all* of the object's methods 
     * and properties, or I will attach *none* of them.
     *
     * @param   object  $object  the object to attach
     * @throws  InvalidArgumentException  if $object is not an object
     * @throws  InvalidArgumentException  if a required method is missing
     * @throws  InvalidArgumentException  if method names collide
     * @throws  InvalidArgumentException  if property names collide
     * @return  self
     * @since   0.1.0
     */
    final public function attach($object) 
    {
        if ( ! is_object($object)) {
            throw new \InvalidArgumentException(
                __METHOD__."() expects parameter one, object, to be, well, an object"
            );
        }
        
        // if the object is an entity
        if ($object instanceof Entity) {
            // the entity can get its own methods and properties, but, first, we 
            //     need to check the entity's required methods and properties
            //
            // if the entity is missing a required method, short circuit
            if ( ! $this->hasAllMethods($object->getRequiredMethods())) {
                // get the missing methods
                $methods = $this->diffMethods($object->getRequiredMethods());
                // get the method names as a human-friendly string
                $list = $this->listMethods($methods);
                // short-circuit
                throw new \InvalidArgumentException(
                    "The destination entity is missing the following required "
                        . "methods: $list"
                );
            }
            
            // if the entity is missing a required property, short-circuit
            if ( ! $this->hasAllProperties($object->getRequiredProperties())) {
                // get the missing properties
                $properties = $this->diffProperties($object->getRequiredProperties());
                // get the property names as a human-friendly string
                $list = $this->listProperties($properties);
                // short-circuit
                throw new \InvalidArgumentException(
                    "The entity is missing the following required properties: $list"
                );
            }
            
            // otherwise, get the entity's methods and properties
            $methods    = $object->getMethods();
            $properties = $object->getProperties();
        } else {
            // otherwise, it's a normal object
            // use refraction to get the object's methods and properties
            //
            $refraction = new RefractionClass($object);
            $methods    = $refraction->getMethods();
            $properties = $refraction->getProperties();
        }
        
        // if method names collide, short-circuit
        if ($this->hasAnyMethods($methods)) {
            // get the colliding methods
            $methods = $this->intersectMethods($methods);
            // get the method names as a human-friendly string
            $list = $this->listMethods($methods);
            // short-circuit
            throw new \InvalidArgumentException(
                __METHOD__."() expects method names to be unique, but the following "
                    . "methods already exist: $list"
            );
        }
        
        // if property names collide, short-circuit
        if ($this->hasAnyProperties($properties)) {
            // get the colliding properties
            $properties = $this->intersectProperties($properties);
            // get the property names as a human-friendly string
            $list = $this->listProperties($properties);
            // short-circuit
            throw new \InvalidArgumentException(
                __METHOD__."() expects property names to be unique, but the "
                    . "following properties already exist: $list"
            );
        }
        
        // otherwise, attach the methods and properties
        $this->attachMethods($methods);
        $this->attachProperties($properties);
        
        return $this;
    }   
    
    /**
     * Detaches an object from the entity
     *
     * Keep in mind, I'll detach properties and methods by name, not the object's 
     * instance. So, you don't have to pass the same object reference to detach 
     * methods and properties as you did to attach them.
     *
     * @param   object  $object  the object to detach
     * @return  self
     * @throws  InvalidArgumentException  if $object is not an object
     * @since   0.1.0
     */
    final public function detach($object)
    {
        if ( ! is_object($object)) {
            throw new \InvalidArgumentException(
                __METHOD__."() expects parameter one, object, to be a, well, object"
            );    
        }
        
        // if the object is an entity
        if ($object instanceof Entity) {
            // get the entity's properties and methods
            $methods    = $object->getMethods();
            $properties = $object->getProperties();
        } else {
            // otherwise, the object is a normal PHP object
            // use refraction to the object's properties and methods
            //
            $refraction = new RefractionClass($object);
            $methods    = $refraction->getMethods();
            $properties = $refraction->getProperties();
        }
        
        // detach the methods and properties
        $this->detachProperties($properties);
        $this->detachMethods($methods);
        
        return $this;
    }
    
    /**
     * Returns the entity's methods indexed by name
     *
     * @return  Jstewmc\Refraction\RefractionMethod[]  
     * @since   0.1.0
     */
    final public function getMethods()
    {
        return array_merge(
            $this->getDefinedMethods(), 
            $this->getTransientMethods()
        );
    } 
    
    /**
     * Returns the entity's properties indexed by name
     *
     * @return  Jstewmc\Refraction\RefractionProperty[]
     * @since   0.1.0
     */
    final public function getProperties()
    {
        return array_merge(
            $this->getDefinedProperties(), 
            $this->getTransientProperties()
        );
    }
    
    
    /* !Protected methods */
    
    /**
     * Attaches a method to the entity
     *
     * Keep in mind, I'm trusting you to have checked to be sure the method doesn't
     * already exist. Otherwise, I will overwrite an existing transient method and
     * mayhem could ensue!
     *
     * @param   Jstewmc\Refraction\RefractionMethod  $method  the method
     * @return  self
     * @since   0.1.0
     */
    final protected function attachMethod(RefractionMethod $method)
    {
        $this->transientMethods[$method->getName()] = $method;
        
        return $this;
    }
    
    /**
     * Attaches an array of methods to the entity
     *
     * Keep in mind, I'm trusting you to have checked to be sure the property doesn't
     * already exist. Otherwise, I will overwrite an existing transient property and
     * mayhem could ensue!
     *
     * @param   Jstewmc\Refraction\RefractionMethod[]  $methods  the methods
     * @return  self
     * @since   0.1.0
     */
    final protected function attachMethods(Array $methods)
    {
        foreach ($methods as $method) {
            $this->attachMethod($method);
        }
        
        return $this;
    }
    
    /**
     * Attaches an array of properties to the entity
     *
     * Keep in mind, I'm trusting you to have checked to be sure the property doesn't
     * already exist. Otherwise, I will overwrite an existing transient property and
     * mayhem could ensue!
     *
     * @param   Jstewmc\Refraction\RefractionProperty[]  $properties  the properties
     * @return  self
     * @since   0.1.0
     */
    final protected function attachProperties(Array $properties)
    {
        foreach ($properties as $property) {
            $this->attachProperty($property);
        }
        
        return $this;
    }
    
    /**
     * Attaches a property to the entity
     *
     * Keep in mind, I'm trusting you to have checked to be sure the property doesn't
     * already exist. Otherwise, I will overwrite an existing transient property and
     * mayhem could ensue!
     *
     * @param   Jstewmc\Refraction\RefractionProperty  $property  the property
     * @return  self
     * @since   0.1.0
     */
    final protected function attachProperty(RefractionProperty $property)
    {
        $this->transientProperties[$property->getName()] = $property;
        
        return $this;
    }
    
    /**
     * Detaches a method from the entity (if it exists)
     *
     * @param  Jstewmc\Refraction\RefractionMethod  $method  the method to detach
     * @return  self
     * @since   0.1.0
     */
    final protected function detachMethod(RefractionMethod $method)
    {
        if ($this->hasMethod($method)) {
            unset($this->transientMethods[$method->getName()]);
        }
        
        return $this;
    }
    
    /**
     * Detaches an array of methods from the entity
     *
     * @param   Jstewmc\Refraction\RefractionMethod[]  $methods  the methods
     * @return  self
     * @since   0.1.0
     */
    final protected function detachMethods(Array $methods)
    {
        foreach ($methods as $method) {
            $this->detachMethod($method);
        }    
        
        return $this;
    }
    
    /**
     * Detaches an array of properties from the entity
     *
     * @param   Jstewmc\Refraction\RefractionProperty[]  $properties  the properties
     * @return  self
     * @since   0.1.0
     */
    final protected function detachProperties(Array $properties)
    {
        foreach ($properties as $property) {
            $this->detachProperty($property);
        }
        
        return $this;
    }
    
    /**
     * Detaches a property from the entity (if it exists)
     *
     * @param  Jstewmc\Refraction\RefractionProperty  $property  the property to 
     *     detach
     * @return  self
     * @since   0.1.0
     */
    final protected function detachProperty(RefractionProperty $property)
    {
        if ($this->hasProperty($property)) {
            unset($this->transientProperties[$property->getName()]);
        }
        
        return $this;
    }
    
    /**
     * Returns the diff of $methods and the entity's methods
     *
     * I'll return an array of the elements in $methods that are not methods of the
     * entity.
     * 
     * @param  Jstewmc\Refraction\RefractionMethod[]|string[]  $methods  the methods
     *     to diff as refraction objects or string method names
     * @return  Jstewmc\Refraction\RefractionMethod[]|string[]
     * @since   0.1.0
     */
    final protected function diffMethods(Array $methods)
    {
        $diff = [];
        
        foreach ($methods as $method) {
            if ( ! $this->hasMethod($method)) {
                $diff[] = $method;
            }
        }
        
        return $diff;
    } 
    
    /**
     * Returns the diff of $properties and the entity's properties
     *
     * I'll return an array that contains all the elements in $properties that are
     * not properties of the entity.
     *
     * @param  Jstewmc\Refraction\RefractionProperty[]|string[]  $properties  the 
     *     properties to diff as refraction properties or string property names
     * @return  Jstewmc\Refraction\RefractionProperty[]|string[]
     * @since   0.1.0
     */
    final protected function diffProperties(Array $properties)
    {
        $diff = [];
        
        foreach ($properties as $property) {
            if ( ! $this->hasProperty($property)) {
                $diff[] = $property;
            }
        }
        
        return $diff;
    }
    
    
    /**
     * Returns a magic method's calling class 
     *
     * I'll return a magic method's calling class using PHP's debug_backtrace()
     * function. I'm smelly. I know it, and I'm not proud of it!
     *
     * I know the calling class is always four levels deep: 
     *
     *     0. this class calling getCallingClass() 
     *     1. this class calling the magic method (e.g., __call())
     *     2. this class calling the transient method
     *     3. the calling class!
     *
     * @return  object 
     * @since   0.1.0
     */
    final protected function getCallingClass()
    {
        // get the calling class line in the trace
        $line = debug_backtrace(
			DEBUG_BACKTRACE_PROVIDE_OBJECT | DEBUG_BACKTRACE_IGNORE_ARGS,
			4
		)[3];
		
		// if the "object" key exists
		if (array_key_exists('object', $line)) {
    		// use it
    		$object = $line['object'];
		} else {
    		// otherwise, the "object" key does not exist
    		// apparently, one special case where this happens is the call to the
    		//     call_user_func_array() function in the __call() magic method
    		// 
		    if (
		        array_key_exists('function', $line) 
		        && $line['function'] === 'call_user_func_array'
            ) {
                // hmmm, just assume the object is this object?
    	        $object = $this;
            }
		}
		
		return $object;
    }
    
    /**
     * Returns the entity's *defined* methods indexed by name
     *
     * @return  Jstewmc\Refraction\RefractionMethod[]
     * @since   0.1.0
     */
    final protected function getDefinedMethods()
    {
        $methods = [];
        
        foreach ((new RefractionClass($this))->getMethods() as $method) {
            if ( ! $this->isBaseMethod($method)) {
                $methods[$method->getName()] = $method;
            }
        }
        
        return $methods;
    }
    
    /**
     * Returns the entity's *defined* properties indexed by name
     *
     * @return  Jstewmc\Refraction\RefractionProperty[]
     * @since   0.1.0
     */
    final protected function getDefinedProperties()
    {
       $properties = [];
       
       foreach ((new RefractionClass($this))->getProperties() as $property) {
           if ( ! $this->isBaseProperty($property)) {
               $properties[$property->getName()] = $property;
           }
       }
       
       return $properties;
    }
    
    /**
     * Lists method names as a human-friendly string (e.g., "foo() and bar()")
     *
     * @param  Jstewmc\Refraction\RefractionMethod[]  $methods  the methods to list,
     *     indexed by name
     * @return  string
     * @since   0.1.0
     */
    final protected function listMethods(Array $methods)
    {
        $list = '';
        
        $names = array_keys($methods);
        
        if (count($names) === 1) {
            $list = $names[0].'()';
        } elseif (count($names) === 2) {
            $list = $names[0].'() and '.$names[1].'()';
        } else {
            $list = implode('(), ', $names).'()';
        }
        
        return $list;
    }
    
    /**
     * Lists property names as a human-friendly string (e.g., "'foo' and 'bar'")
     *
     * @param  Jstewmc\Refraction\RefractionProperty[]  $properties  the properties
     *     to list, indexed by name
     * @return  string
     * @sicnce  0.1.0
     */
    final protected function listProperties(Array $properties)
    {
        $list = '';
        
        $names = array_keys($properties);
        
        if (count($names) === 1) {
            $list = '\''.$names[0].'\'';
        } elseif (count($names) === 2) {
            $list = '\''.$names[0].'\' and \''.$names[1].'\'';
        } else {
            $list = '\''.implode('\', \'', $names).'\'';
        }
        
        return $list;
    }
    
    /**
     * Returns the entity's *transient* methods indexed by name
     *
     * @return  Jstewmc\Refraction\RefractionMethod[]
     * @since   0.1.0
     */
    final protected function getTransientMethods()
    {
        return $this->transientMethods;
    }
    
    /**
     * Returns the entity's *transient* properties indexed by name
     *
     * @return  Jstewmc\Refraction\RefractionProperty[]
     * @since   0.1.0
     */
    final protected function getTransientProperties()
    {
       return $this->transientProperties; 
    }
    
    /**
     * Returns true if the entity has the method
     *
     * @param   Jstewmc\Refraction\RefractionMethod|string  $method  the method to 
     *     test as a refraction object or string method name
     * @return  bool
     * @since   0.1.0
     */
    final protected function hasMethod($method)
    {
        if ($method instanceof RefractionMethod) {
            $method = $method->getName();
        }
        
        return array_key_exists($method, $this->getMethods());
    }
    
    /**
     * Returns true if the entity has *one or more* of the methods
     *
     * @param  Jstewmc\Refraction\RefractionMethod[]|string[]  $methods  the methods 
     *     to test as refraction objects or string method names
     * @return  bool
     * @since   0.1.0
     */
    final protected function hasAnyMethods(Array $methods)
    {
        foreach ($methods as $method) {
            if ($this->hasMethod($method)) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Returns true if the entity has *all* of the methods
     *
     * @param   Jstewmc\Refraction\RefractionMethod[]|string[]  $methods  the methods
     *     to test as refraction objects or string method names
     * @return  bool
     * @since   0.1.0
     */
    final protected function hasAllMethods(Array $methods)
    {
        return $methods === array_filter($methods, function ($method) {
            return $this->hasMethod($method);
        });
    }
    
    /**
     * Returns true if the entity has *one or more* of the properties
     *
     * @param   Jstewmc\Refraction\RefractionProperty[]|string[]  $properties  the 
     *     properties to test as refraction objects or string property names
     * @return  bool
     * @since   0.1.0
     */
    final protected function hasAnyProperties(Array $properties)
    {
        foreach ($properties as $property) {
            if ($this->hasProperty($property)) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Returns true if the entity has *all* of the properties
     *
     * @param  Jstewmc\Refraction\RefractionProperty[]|string[]  $properties  the
     *     properties to test as refraction objects or string property names
     * @return  bool
     * @since   0.1.0
     */
    final protected function hasAllProperties(Array $properties)
    {
        return $properties === array_filter($properties, function ($property) {
            return $this->hasProperty($property);
        });
    }
    
    /**
     * Returns true if the entity has the property 
     *
     * @param   Jstewmc\Refraction\RefractionProperty|string  $property  the property
     *     to test as a refraction property or string property name
     * @return  bool
     * @since   0.1.0
     */
    final protected function hasProperty($property)
    {
        if ($property instanceof RefractionProperty) {
            $property = $property->getName();
        } 
    
        return array_key_exists($property, $this->getProperties());
    }
    
    /**
     * Returns the intersection of $methods and the entity's methods
     *
     * @param   Jstewmc\Refraction\RefractionMethod[]  $methods  the methods to test
     *     indexed by method name
     * @return  Jstewmc\Refraction\RefractionMethod[]  the intersecting methods, 
     *     indexed by method name
     * @since   0.1.0
     */
    final protected function intersectMethods(Array $methods)
    {
        return array_intersect_key($methods, $this->getMethods());
    }
     
    /**
     * Returns the intersection of $properties and the entity's properties
     *
     * @param   Jstewmc\Refraction\RefractionProperty[]  $methods  the properties to
     *     test, indexed by property name
     * @return  Jstewmc\Refraction\RefractionProperty[]  the intersecting properties, 
     *     indexed by method name
     * @since   0.1.0
     */
    final protected function intersectProperties(Array $properties)
    {
        return array_intersect_key($properties, $this->getProperties());
    }

    /**
     * Returns true if the method is defined in the entity class
     *
     * I'll return true if the method is defined in this class file (i.e., a method
     * of the abstract base entity class). That way, we can distinguish the methods 
     * *every* entity has from the methods defined in child classes.
     *
     * @return  bool
     * @since   0.1.0
     */    
    final protected function isBaseMethod(RefractionMethod $method)
    {
        return $method->class == __CLASS__;
    }
    
    /**
     * Returns true if the property is defined in the entity class
     *
     * I'll return true if the property is defined in this class file (i.e., a 
     * property of the abstract base entity class). That way, we can distinguish the 
     * properties *every* entity has from the properties defined in child classes.
     *
     * @return  bool
     * @since   0.1.0
     */
    final protected function isBaseProperty(RefractionProperty $property) 
    {
        return $property->class == __CLASS__;
    }
    
    /**
     * Returns true if the method is visible to the object
     *
     * A method is visible to a calling class if the method is public (and visible
     * to any calling class) or the calling class is this class (and the method is
     * protected or private).
     *
     * @param   Jstewmc\Refraction\RefractionMethod  $method  the method
     * @param   object  $object  the calling class
     * @return  bool
     * @since   0.1.0
     */
    final protected function isMethodVisible($method, $object)
    {
        return $method->isPublic() || $object === $this;
    }
    
    /**
     * Returns true if the property is visible to the object
     *
     * A property is visible to a calling class if the property is public (and 
     * visible to any calling class) or the calling class is this class (and the 
     * property protected or private).
     *
     * @param   Jstewmc\Refraction\RefractionProperty  $property  the property
     * @param   object  $object  the calling class
     * @return  bool
     * @since   0.1.0
     */
    final protected function isPropertyVisible($property, $object)
    {
        return $property->isPublic() || $object === $this;
    }
}
