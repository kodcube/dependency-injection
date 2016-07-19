<?php
namespace KodCube\DependencyInjection\Test\UnitTest;

use KodCube\DependencyInjection\Container;
use KodCube\DependencyInjection\Exception\NotFoundException;
use KodCube\DependencyInjection\Test\Mocks;

class ContainerInvokeTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Check Alias to Class Map
     */
    public function testNotFoundAlias()
    {
        $this->setExpectedException(NotFoundException::class);
        $container = new Container(['MyAlias' => 'stdClass']);
        $container('MyAliasNotFound');
    }

    public function testGetClassNotFound()
    {
        $this->setExpectedException(NotFoundException::class);

        $container = new Container();

        $container('ClassNotExist');

    }

    public function testGetObjectParameter()
    {
        $this->setExpectedException('TypeError');

        $container = new Container();

        $container(new \stdClass);

    }

    public function testGetIntegerParameter()
    {
        $this->setExpectedException(NotFoundException::class);

        $container = new Container();

        $container(123);

    }




}
