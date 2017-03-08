<?php
namespace KodCube\DependencyInjection\Test\UnitTest;

use KodCube\DependencyInjection\{ Container, NotFoundException };
use stdClass;
use PHPUnit\Framework\TestCase;

class ContainerInvokeTest extends TestCase
{

    /**
     * Check Alias to Class Map
     * @test
     * @expectedException Psr\Container\NotFoundExceptionInterface
     */
    public function AliasNotFoundAlias()
    {
        $container = new Container(['MyAlias' => 'stdClass']);
        $this->assertInstanceOf('stdClass',$container('MyAliasNotFound'));
    }

    /**
     * Check Alias to Class Map
     * @test
     * @expectedException Psr\Container\NotFoundExceptionInterface
     */

    public function ClassNotFound()
    {
        $container = new Container();
        $container('ClassNotExist');

    }


    /**
     * Check Passing Object as Parameter
     * @test
     * @expectedException TypeError
     */
    public function GetObjectParameter()
    {
        $container = new Container();

        $container(new stdClass);

    }
    /**
     * Check Passing Integer as Parameter
     * @test
     * @expectedException Psr\Container\NotFoundExceptionInterface
     */

    public function GetIntegerParameter()
    {
        $container = new Container();
        $container(123);

    }




}
