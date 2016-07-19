<?php
namespace KodCube\DependencyInjection\Test\UnitTest;

use KodCube\DependencyInjection\Container;
use Interop\Container\Exception\NotFoundException;
use Interop\Container\Exception\ContainerException;
use KodCube\DependencyInjection\Test\Mocks;

class ContainerExceptionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Check Exception Thrown for Missing Alias
     */
    public function testNotFoundAlias()
    {
        $this->setExpectedException(NotFoundException::class);
        $container = new Container(['MyAlias' => 'stdClass']);
        $container->get('MyAliasNotFound');
    }

    /**
     * Check Exception Thrown for Class Not Found   
     */   
    public function testGetClassNotFound()
    {
        $this->setExpectedException(NotFoundException::class);

        $container = new Container();

        $container->get('ClassNotExist');

    }

    /**
     * Test Passing Object to get method
     */   

    public function testGetObjectParameter()
    {
        $this->setExpectedException('TypeError');

        $container = new Container();

        $container->get(new \stdClass);

    }

    /**
     * Test Passing Integer to get method
     */
     
    public function testGetIntegerParameter()
    {
        $this->setExpectedException(NotFoundException::class);

        $container = new Container();

        $container->get(123);

    }
    
    /**
     * Test Missing Class Dependency 
     */
    
    public function testMissingClassDependency()
    {
        $this->setExpectedException(ContainerException::class);

        $container = new Container();

        $container->get(Mocks\ClassMissingDependency::class);
    }

}
