<?php
namespace KodCube\DependencyInjection\Test\UnitTest;

use KodCube\DependencyInjection\Container;
use PHPUnit\Framework\TestCase;
use stdClass;
/**
 * Test the use of Aliases/Service Locators 
 */

class ContainerGetMethodTest extends TestCase
{

    /**
     * Check Alias to Class Map
     * @test
     */
    public function AliasToClass()
    {
        $container = new Container(['MyAlias' => 'stdClass']);
        $this->assertInstanceOf('stdClass',$container->get('MyAlias'));
    }

    /**
     * Check Alias to Builder Config
     * @test
     */
    public function AliasToBuilderConfig()
    {
        $container = new Container([
            'MyAlias' => ['class' => 'stdClass']
        ]);
        $this->assertInstanceOf('stdClass',$container->get('MyAlias'));
    }

    /**
     * Test Alias to Builder with Multiple Arguments
     * @test
     */
    public function AliasToBuilderConfigWithMultipleArguments()
    {
        $container = new Container([
            'MyAlias' => [
                'class' => ClassMultipleArguments::class,
                'argument1',
                'argument2'
            ]
        ]);

        $this->assertObjectHasAttribute('argument0',$container->get('MyAlias'));
        $this->assertObjectHasAttribute('argument1',$container->get('MyAlias'));
    }

    /**
     * Test Alias to Builder with key/value pairs
     * @test
     */
    public function AliasToBuilderConfigWithArrayArgument()
    {
        $container = new Container([
            'MyAlias' => [
                'class' => ClassTraversableArgument::class,
                'key1' => 'argument1',
                'key2' => 'argument2'
            ]
        ]);

        $this->assertObjectHasAttribute('key1',$container->get('MyAlias'));
        $this->assertObjectHasAttribute('key2',$container->get('MyAlias'));
    }

    /**
     * Test Class to Alias
     * @test
     */
    public function ClassToAlias()
    {
        $container = new Container([
            'MyAlias' => [
                'class' => ClassMultipleArguments::class,
                'argument1',
                'argument2'
            ],
            'Vendor\Package\Class' => 'MyAlias'
        ]);
        $this->assertInstanceOf(ClassMultipleArguments::class,$container->get('Vendor\Package\Class'));
    }

    /**
     * Test Interface to Alias
     * @test
     */
    public function InterfaceToAlias()
    {
        $container = new Container([
            'MyAlias' => 'stdClass',
            'Vendor\Package\Interface' => 'MyAlias'
        ]);
        $this->assertInstanceOf('stdClass',$container->get('Vendor\Package\Interface'));
    }

    /**
     * Test Aliasing One Class to another Class
     * @test
     */
    public function ClassToClass()
    {
        $container = new Container([
            Class1::class => Class2::class
        ]);

        //$container = $container->with(Class1::class,Class2::class);

        $this->assertInstanceOf(Class2::class,$container->get(Class1::class));

    }

    /**
     * Test Alias to Anonymous Function
     * @test
     */
    public function AliasToAnonymousFunction()
    {
        $container = new Container([
            'MyAlias' => function ($container) {
                return new stdClass();
            }
        ]);

        $this->assertInstanceOf('stdClass',$container->get('MyAlias'));

    }


    /*
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


class ClassMultipleArguments
{
    public function __construct(...$args)
    {
        foreach ($args AS $i=>$argument) {
            $this->{'argument'.$i} = $argument;
        }
    }
}

class ClassTraversableArgument
{
    public function __construct($args)
    {
        foreach ($args AS $key=>$argument) {
            $this->$key = $argument;
        }
    }
}

class Class1
{
    public function __construct(...$args)
    {
        foreach ($args AS $i=>$argument) {
            $this->{'argument'.$i} = $argument;
        }
    }
}

class Class2
{
    public function __construct(...$args)
    {
        foreach ($args AS $i=>$argument) {
            $this->{'argument'.$i} = $argument;
        }
    }
}