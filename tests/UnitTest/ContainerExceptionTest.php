<?php
namespace KodCube\DependencyInjection\Test\UnitTest;

use KodCube\DependencyInjection\Container;
use KodCube\DependencyInjection\Test\Mocks;
use PHPUnit\Framework\TestCase;
use stdClass;

class ContainerExceptionTest extends TestCase
{

    /**
     * Check Exception Thrown for Missing Alias
     * @test
     * @expectedException Psr\Container\NotFoundExceptionInterface
     */
    public function AliasNotFound()
    {
        $container = new Container(['MyAlias' => 'stdClass']);
        $container->get('MyAliasNotFound');
    }

    /**
     * Check Exception Thrown for Class Not Found
     * @test
     * @expectedException Psr\Container\NotFoundExceptionInterface
     */
    public function GetClassNotFound()
    {
        $container = new Container();

        $container->get('ClassNotExist');

    }

    /**
     * Test Passing Object to get method
     * @test
     * @expectedException TypeError
     */   

    public function testGetObjectParameter()
    {
        $container = new Container();

        $container->get(new stdClass);

    }

    /**
     * Test Passing Integer to get method
     * @test
     * @expectedException Psr\Container\NotFoundExceptionInterface
     */
     
    public function GetIntegerParameter()
    {
        $container = new Container();

        $container->get(123);

    }
    
    /**
     * Test Missing Class Dependency
     * @test
     * @expectedException Psr\Container\ContainerExceptionInterface
     */
    
    public function MissingClassDependency()
    {
        $container = new Container();

        $container->get(Mocks\ClassMissingDependency::class);
    }

}
