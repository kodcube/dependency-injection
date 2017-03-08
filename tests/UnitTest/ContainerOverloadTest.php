<?php
namespace KodCube\DependencyInjection\Test\UnitTest;

use KodCube\DependencyInjection\Container;
use PHPUnit\Framework\TestCase;

class ContainerOverloadTest extends TestCase
{

    /**
     * Check Alias to Class Map
     * @test
     */
    public function testOverloadAlias()
    {
        $container = new Container(['MyAlias' => 'stdClass']);
        $this->assertInstanceOf('stdClass',$container->MyAlias());
    }

    /**
     * Test Overload Alias Not Found
     * @test
     * @expectedException Psr\Container\NotFoundExceptionInterface
     */
    public function testOverloadAliasNotFound()
    {
        $container = new Container();

        $container->ClassNotExist();

    }





}
