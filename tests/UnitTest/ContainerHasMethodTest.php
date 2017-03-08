<?php
namespace KodCube\DependencyInjection\Test\UnitTest;

use KodCube\DependencyInjection\Container;
use KodCube\DependencyInjection\Test\Mocks;
use PHPUnit\Framework\TestCase;

class ContainerHasMethodTest extends TestCase
{

    /**
     * Test Alias exists - True
     * @test
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
     * @test
     */
    public function classInMap()
    {
        $container = new Container([
            'DoesNotExist' => [
                'argument1',
                'argument2'
            ]
        ]);

        $this->assertTrue($container->has('DoesNotExist'));
    }

    /**
     * Check if class exists as autowired dependency
     * @test
     */
    public function hasAutowiredClass()
    {
        $container = new Container();

        $this->assertTrue($container->has(TestCase::class));
    }

    /**
     * Test for Alias that does not exist
     * @test
     */
    public function aliasDoesNotExist()
    {
        $container = new Container();

        $this->assertFalse($container->has('MyAliasNot'));

    }

    /**
     * Test for Class that does not exist or cannot be autoloaded
     * @test
     */
    public function noAliasNoClass()
    {
        $container = new Container();

        $this->assertFalse($container->has('KodCube\DoesNotExist'));

    }

}
