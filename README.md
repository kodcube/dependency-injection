# Dependency Injection Container / Service Locator / Object Builder

This package is Recursive Dependency Injection Container (DiC) / Service Locator / Object Builder

It has been designed to take it's dependency configuration map as part of it's construction,
so rather than setting up all the dependencies at runtime they can be loaded from a configuration file or files.

So as long as you can create an array, the configuration is injected at construction.

### Main Features 
* Build a Service/Object/Class based on a class name or alias
* Build a Class/Object that requires other dependencies
* Cache built Service/Object/Class for reuse in other classes (e.g. Database Connections)
* Build a Object/Class with a combination of passed and required dependencies
* Recursive Object Creation


### Limitations
* Does not inject dependencies for methods other than __constructor 
* Does not inject dependencies for setters

### Requirements
* PHP 7
* container-interop/container-interop




* [Usage](#usage) - _Basic usage examples_
  * [Create Container](#create-container)
  * [Get Object from Container](#get-object-from-container)
  * [Check if Alias\Class Exists in Container](#check-if-aliasclass-exists-in-container)
  * [Make Object](#make-object)
* [Methods](https://github.com/kodcube/dependency-injection-container/wiki/Container#methods)
* [Aliases](https://github.com/kodcube/dependency-injection-container/wiki/Aliases-&-Service-Locators)
* [AutoWiring](https://github.com/kodcube/dependency-injection-container/wiki/Autowiring)

[Configuration Examples](https://github.com/kodcube/dependency-injection-container/wiki/Configuration)

## Usage

### Create Container

``` PHP
$di = new GunnaPHP\DI\Container();

or

$di = new GunnaPHP\DI\Container($config);

or

$di = new GunnaPHP\DI\Container([
  'MyAlias' => 'Vendor\Package\Class',
  'Vendor\Package\Interface' => 'Vendor\Package\Class'
])

``` 

### Get Object from Container using an alias

Using Alias
``` PHP
$object = $di->get('MyAlias');

or 

$object = $di('MyAlias');

or
 
$object = $di->MyAlias(); 
```

Using Class Name 
``` PHP
$object = $di->get('Vendor\Package\Class');

or 

$object = $di('Vendor\Package\Class');
```

Using Interface Name (requires dependency map) 
``` PHP
$object = $di->get('Vendor\Package\Interface');

or 

$object = $di('Vendor\Package\Interface');
```

### Check if Alias\Class Exists in Container
``` PHP
Alias
$object = $di->has('MyAlias');

Class
$object = $di->has('Vendor\Package\Class');
```

### Make Object
Make a object using the DiC using passed arguments. 

This will also take advantage of the autowiring properties of the container.

Note: Objects created with additional arguments are not cached by the container.

``` PHP
$object = $di->make('Vendor\Package\Class','argument1','argument2');
```


