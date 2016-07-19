<?php
namespace KodCube\DependencyInjection\Test\UnitTest;

use KodCube\DependencyInjection\Container;
use KodCube\DependencyInjection\Test\Mocks;

class ContainerHasMethodTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test Alias exists - True
     */
    public function testHasAlias()
    {
        $container = new Container([
            'MyAlias' => 'stdClass'
        ]);

        $this->assertTrue($container->has('MyAlias'));

    }

    /**
     * Check if class exists either in dependency map,
     * but not in in autoloader
     */
    public function testClassInMap()
    {
        $container = new Container([
            'GunnaPHP\DI\Test\Mocks\DoesNotExist' => [
                'argument1',
                'argument2'
            ]
        ]);

        $this->assertTrue($container->has(Mocks\ClassTraversableArgument::class));
    }

    /**
     * Check if class exists as autowired dependency
     */
    public function testHasClass()
    {
        $container = new Container();

        $this->assertTrue($container->has(Mocks\ClassTraversableArgument::class));
    }

    /**
     * Test for Alias that does not exist
     */
    public function testHasNotAlias()
    {
        $container = new Container();

        $this->assertFalse($container->has('MyAliasNot'));

    }

    /**
     * Test for Class that does not exist or cannot be autoloaded
     */
    public function testHasNotClass()
    {
        $container = new Container();

        $this->assertFalse($container->has('GunnaPHP\DI\Test\Mocks\DoesNotExist'));

    }

}
