<?php
namespace KodCube\DependencyInjection\Test\UnitTest;

use KodCube\DependencyInjection\Container;
use Interop\Container\Exception\NotFoundException;
use KodCube\DependencyInjection\Test\Mocks;

/**
 * Test the use of Aliases/Service Locators 
 */

class ContainerAliasTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Check Alias to Class Map
     */
    public function testAliasToClass()
    {
        $container = new Container(['MyAlias' => 'stdClass']);
        $this->assertInstanceOf('stdClass',$container->get('MyAlias'));
    }

    /**
     * Check Alias to Builder Config
     */
    public function testAliasToBuilderConfig()
    {
        $container = new Container([
            'MyAlias' => ['class' => 'stdClass']
        ]);
        $this->assertInstanceOf('stdClass',$container->get('MyAlias'));
    }

    /**
     * Test Alias to Builder with Multiple Arguments
     */

    public function testAliasToBuilderConfigWithMultipleArguments()
    {
        $container = new Container([
            'MyAlias' => [
                'class' => Mocks\ClassMultipleArguments::class,
                'argument1',
                'argument2'
            ]
        ]);
        $this->assertObjectHasAttribute('argument0',$container->get('MyAlias'));
        $this->assertObjectHasAttribute('argument1',$container->get('MyAlias'));
    }

    /**
     * Test Alias to Builder with key/value pairs
     */

    public function testAliasToBuilderConfigWithArrayArgument()
    {
        $container = new Container([
            'MyAlias' => [
                'class' => Mocks\ClassTraversableArgument::class,
                'key1' => 'argument1',
                'key2' => 'argument2'
            ]
        ]);

        $this->assertObjectHasAttribute('key1',$container->get('MyAlias'));
        $this->assertObjectHasAttribute('key2',$container->get('MyAlias'));
    }

    /**
     * Test Class to Alias
     */

    public function testClassToAlias()
    {
        $container = new Container([
            'MyAlias' => [
                'class' => Mocks\ClassMultipleArguments::class,
                'argument1',
                'argument2'
            ],
            'Vendor\Package\Class' => 'MyAlias'
        ]);
        $this->assertInstanceOf(Mocks\ClassMultipleArguments::class,$container->get('Vendor\Package\Class'));
    }


    public function testInterfaceToAlias()
    {
        $container = new Container([
            'MyAlias' => 'stdClass',
            'Vendor\Package\Interface' => 'MyAlias'
        ]);
        $this->assertInstanceOf('stdClass',$container->get('Vendor\Package\Interface'));
    }

    /**
     * Test Aliasing One Class to another
     */
/*
    public function testClassToClass()
    {
        $container = new Container();

        $container = $container->with(Mocks\Class1::class,Mocks\Class2::class);

        $this->assertInstanceOf(Mocks\Class2::class,$container->get(Mocks\Class1::class));

    }

    public function testSetGetAliasToBuilderConfig()
    {
        $container = new Container();

        $container = $container->with('MyAlias',[
            'class' => 'stdClass'
        ]);

        $this->assertInstanceOf('stdClass',$container->get('MyAlias'));

    }
    
    public function testSetGetAliasToObject()
    {
        $container = new Container();

        $container->set('MyAlias',new \stdClass);

        $this->assertInstanceOf('stdClass',$container->get('MyAlias'));

    }

    public function testSetGetAliasToAnonymousFunction()
    {
        $container = new Container();

        $container->set('MyAlias',function () {
            return new \stdClass;
        });

        $this->assertInstanceOf('stdClass',$container->get('MyAlias'));

    }

    public function testConfigHasAlias()
    {
        $container = new Container([
            'MyAlias' => 'stdClass'
        ]);

        $this->assertTrue($container->has('MyAlias'));

    }
    
    public function testConfigHasClass()
    {
        $container = new Container();

        $this->assertTrue($container->has('GunnaPHP\\DI\\Test\\Mocks\\ClassTraversableArgument'));

    }

    public function testConfigHasNotAlias()
    {
        $container = new Container([
            'MyAlias' => 'stdClass'
        ]);

        $this->assertFalse($container->has('MyAliasNot'));

    }

    public function testConfigHasNotClass()
    {
        $container = new Container();

        $this->assertFalse($container->has('DoesNotExist'));

    }
*/
}
