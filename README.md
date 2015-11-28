# Transient
Transient properties and methods in PHP.

For example:

```php
use Jstewmc\Transient\Entity;

class Foo extends Entity
{
    public function foo()
    {
        echo 'foo';
    }
    
    // note there is no bar() method defined!
}

class Bar extends Entity
{
    public function bar()
    {
        echo 'bar';
    }
}

// instantiate foo and bar
$foo = new Foo();
$bar = new Bar();

// attach bar to foo
$foo->attach($bar);

// call foo's bar() method?!
$foo->bar();
```

The previous example would produce the following output:

```
bar
```

Cool huh?! The Transient library allows you to move methods and properties between normal PHP classes at run-time.

## Usage

To use the Transient library, both the _source_ and the _destination_ object must extend the `Entity` classs. 

For example:

```php
use Jstewmc\Transient\Entity;

class Foo extends Entity
{
    protected $foo = 'foo';
    
    public function getFoo()
    {
        return $this->foo;
    }
    
    public function setFoo($foo)
    {
        $this->foo = $foo;
        
        return;
    }
}    

class Bar extends Entity
{
    protected $bar = 'bar';
    
    public function getBar()
    {
        return $this->bar;
    }
    
    public function setBar($bar)
    {
        $this->bar = $bar;
        
        return $this;
    }
}

class Baz entends Entity
{
    public $baz = 'baz';    
}
```

You can attach one or more entities to any other entity using the `attach()` method:

```php

// ...continuing the example above

$foo = new Foo();
$bar = new Bar();
$baz = new Baz();

$foo->attach($bar);
$foo->attach($baz);
```

Once a _source_ entity has been attached, you can use its methods and properties as if they were defined in the _destination_ entity (i.e., the magic `$this` variable in the _source_ entity's methods will point to the _destination_ object):

```php
// ... continuing the example above

$foo->getFoo();  // returns "foo"
$foo->getBar();  // returns "bar"
$foo->baz;       // returns "baz"

$foo->setFoo('baz');
$foo->setBar('qux');
$foo->baz = 'quux';

$foo->getFoo();  // returns "baz"
$foo->getBar();  // returns "qux"  
$foo->baz;       // returns "quux"
```

When you're done, you can detach the _source_ entity from the _destination_ entity:

``` 
// ... continuing the example above

count($foo->getMethods());  // returns 4

$foo->detach($bar);

count($foo->getMethods());  // returns 2
```

If the need arises (and it probably won't), you can get an entity's properties and methods as [Refractions](https://github.com/jstewmc/refraction) via the `getMethods()` and `getProperties()` methods. (Refraction is a library I wrote for use in this library.)


## Limitations

Of course, this library isn't perfect. There are limitations like unique names, reserved names, and magic.

### Unique names

You MUST use unique property and method names. You cannot attach a _source_ entity to a _destination_ entity if the two objects have a method or property name in common. Otherwise, an `InvalidArgumentException` will be thrown.

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

// this will NOT work (throws InvalidArgumentException)!
$foo1->attach($foo2);
```

### Reserved names

You MUST NOT override the `Entity` base property and method names. Otherwise, your entity will likely malfunction, or at the very least, give you wacky results.

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

When attaching a _source_ entity to a _destination_ entity:

* A _destination_ entity can see the _private_, _protected_, and _public_ methods and properties of a _source_ entity.
* A _destination_ entity can see the _protected_ and _public_ methods and properties of a _source_ entity's parent.

Once attached, an outside class can only see the _destination_ entity's _public_ methods and properties (which, of course, now include the public methods and public properties of any attached _source_ entity).

## That's it!

That's about ti! Of course, this is the first version, and I'm sure I missed something. Any issues, comments, and suggestions are appreciated.

## About

In late 2015, I was introduced to the [Data Context Interaction (DCI) paradigm](https://en.wikipedia.org/wiki/Data,_context_and_interaction). It really interested me, because it seemed to solve a common development problem: where do I put this method when it involves multiple objects? 

Programs used to be procedures. It was (pretty) obvious what the program did, but you repeated yourself all the time. Now, programs are loosely-coupled objects. You never repeat yourself, but you have no idea what the program does. 

It's almost as if we went too far in the object-oriented direction. We need a way to encapsulate properties and methods into objects, but we also need a way to collect the steps to accomplish an objective. It's this balance between object-oriented design and procedural design that interested me about the DCI pattern. 

Unfortunately, PHP does not lend itself to the DCI pattern (which requires the fluid movement of properties and methods between objects) very well. PHP does not allow the addition of methods or properties at run-time. That's why I build the Transient library. With Transient, you can attach objects to each other, and they'll behave as if they were the same object.

## Author

[Jack Clayton](clayjs0@gmail.com)


## License

[MIT]()


## Version

### dev-master - November 27, 2015

* Initial release

