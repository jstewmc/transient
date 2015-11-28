# Transient
Transient properties and methods in PHP.

For example:

```php
use Jstewmc\Transient\Entity;

// let's define a simple transient entity, Foo
// note that Foo does have a "foo" property
// note that Foo does not have a bar() method
//
class Foo extends Entity
{
    protected $foo = 1;
    
    public function foo()
    {
        return $this->foo;
    }
}

// and, let's define a simple class
// note that Bar does not have a "foo" property
// note that Bar does have a bar() method
//
{
    public function bar()
    {
        return $this->foo + 1;
    }
}

// instantiate foo and bar
$foo = new Foo();
$bar = new Bar();

// attach bar to foo
$foo->attach($bar);

// call foo's methods
$foo->foo();  // returns 1
$foo->bar();  // returns 2 (!)
```

Cool huh?! The Transient library allows you to move methods and properties between otherwise normal PHP classes at run-time.

## Usage

To attach methods and properties to another object using the `attach()` method, the _destination_ object must extend the `Entity` classs:

```php
use Jstewmc\Transient\Entity;

class Foo extends Entity
{
    public $foo = 'foo';
}   

class Bar
{
    public $bar = 'bar';
}

$foo = new Foo();
$bar = new Bar();

$foo->attach($bar);

$foo->foo;  // returns "foo"
$foo->bar;  // returns "bar"

// obviously, this will NOT work!
$bar->attach($foo);
```

You can attach entities to other entities. But, just keep in mind, properties and methods are only attached in one direction. Order matters:

```php
use Jstewmc\Transient\Entity;

class Foo extends Entity
{
    public $foo = 'foo';
}   

class Bar extends Entity
{
    public $bar = 'bar';
} 

class Baz extends Entity
{
    public $baz = 'baz';
}

$foo = new Foo();
$bar = new Bar();
$baz = new Baz();

$bar->attach($baz);
$foo->attach($bar);

$foo->foo;  // returns "foo"
$foo->bar;  // returns "bar"
$foo->baz;  // returns "baz"

$bar->foo;  // throws OutOfBoundsException
$baz->foo;  // throws OutOfBoundsException
```

Once a _source_ object or entity has been attached, you can use its methods and properties as if they were defined in the _destination_ entity (i.e., the magic `$this` variable in the _source_ entity's methods will point to the _destination_ object):

```php
use Jstewmc\Transient\Entity;

class Foo extends Entity
{
    protected $foo = 1;
}

class Bar
{
    public function foo()
    {
       return $this->foo;
    }  
}

$foo = new Foo();
$bar = new Bar();

$foo->attach($bar);

$foo->foo();  // returns 1
```

When you're done, you can detach the _source_ object from the _destination_ entity:

```php
use Jstewmc\Transient\Entity;

class Foo extends Entity
{
    protected $foo = 1;
}

class Bar
{
    public function foo()
    {
       return $this->foo;
    }  
}

$foo = new Foo();
$bar = new Bar();

$foo->attach($bar);

count($foo->getMethods());  // returns 1

$foo->detach($bar);

count($foo->getMethods());  // returns 0
```

If the need arises, you can get an entity's properties and methods as [Refractions](https://github.com/jstewmc/refraction) via the `getMethods()` and `getProperties()` methods (refraction is a library I wrote for use in this library).


## Limitations

Of course, this library isn't perfect. There are limitations like unique names, reserved names, and magic.

### Unique names

You MUST use unique property and method names. You cannot attach a _source_ object to a _destination_ entity if the two objects have a method or property name in common. Otherwise, an `InvalidArgumentException` will be thrown.

For example, the following code _will not work_:

```php
use Jstewmc\Transient\Entity;

class Foo1 extends Entity
{
    protected $foo;
    
    public function foo()
    {
        return;
    }
}

class Foo2 extends Entity
{
    protected $foo;
    
    public function foo()
    {
        return;
    }
}

$foo1 = new Foo1();
$foo2 = new Foo2();

// this will NOT work, because the method and property names collide
// this will throw an InvalidArgumentException!
//
$foo1->attach($foo2);
```

### Reserved names

You MUST NOT override the `Entity` base property and method names. Otherwise, your entity will probably malfunction, or at the very least, give you wacky results.

I've tried to disallow overriding the base methods where I can with the `final` keyword, but, just to be safe, you should treat the following property and method names as reserved:

#### Property names

* `transientProperties`
* `transientMethods`

#### Method names

* `attach()`
* `attachMethod()`
* `attachMethods()`
* `attachProperties()`
* `attachProperty()`
* `detach()`
* `detachMethod()`
* `detachMethods()`
* `detachProperties()`
* `detachProperty()`
* `getCallingClass()`
* `getDefinedMethods()`
* `getDefinedProperties()`
* `getMethods()`
* `getProperties()`
* `getTransientMethods()`
* `getTransientProperties()`
* `listMethods()`
* `listProperties()`
* `hasMethod()`
* `hasMethods()`
* `hasProperties()`
* `hasProperty()`
* `intersectMethods()`
* `insersectProperties()`
* `isBaseMethod()`
* `isBaseProperty()`
* `isMethodVisible()`
* `isPropertyVisible()`

You should also take care to preserve the `Entity` functionality when extending the following magic methods:

* `__call()`
* `__get()`
* `__isset()`
* `__set()`
* `__unset()`

Luckily, most of the base methods and properties include the actual word "method" or "property". So, unless you're writing a funky object, the chance of an accidental collision is pretty small.

### Magic

You SHOULD be ok with this library using PHP's magic methods and reflection class in the background. I know they are avoided by some developers, but this library necessarily uses both. 


## Visibility

This library is visiblity safe.

When attaching a _source_ object to a _destination_ entity:

* A _destination_ entity can see the _private_, _protected_, and _public_ methods and properties of a _source_ object.
* A _destination_ entity can see the _protected_ and _public_ methods and properties of a _source_ object's parents.
* An outside class can only see the _destination_ entity's _public_ methods and properties (which, of course, include the public methods and public properties of any attached _source_ object).

## That's it!

That's about it! This is the first version. Of course, I'm sure I missed something. Any issues, comments, and suggestions are appreciated.

Here are a few improvements I'm thinking about:

* ~~Do you have to attach an Entity? Why not just allow the programmer to attach an entity or a vanilla object?~~ (Done!)
* We should allow a _source_ entity to define requirements, like an interface it expects the _destination_ entity to implement at a minimum.


## About

In late 2015, I was introduced to the [Data Context Interaction (DCI) paradigm](https://en.wikipedia.org/wiki/Data,_context_and_interaction). It really interested me, because it seemed to solve a common development problem: where do I put this method when it involves multiple objects? 

Programs used to be procedures. It was (pretty) obvious what the program did, but you repeated yourself all the time. Now, programs are loosely-coupled objects. You never repeat yourself, but you have no idea what the program does. 

It's almost as if we went too far in the object-oriented direction. We need a way to encapsulate properties and methods into objects, of course. But, we also need a way to collect steps into a cohesive procedure to accomplish an objective. It's this balance between object-oriented design and procedural design that interested me about the DCI pattern. 

Unfortunately, PHP does not lend itself to the DCI pattern very well. DCI requires the fluid movement of properties and methods between objects, but PHP does not allow the addition of methods or properties to an object after compile-time. 

That's why I built the Transient library. With Transient, you can attach objects to each other, and they'll behave as if they were the same object. Woot!

## Author

[Jack Clayton](clayjs0@gmail.com)


## License

[MIT]()


## Version

### dev-mater - November 28, 2015

* Updated `attach()` and `detach()` to accept any object, not just entities.

### dev-master - November 27, 2015

* Initial release

