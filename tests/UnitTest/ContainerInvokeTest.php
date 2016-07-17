<?php
namespace KodCube\Container\Test\UnitTest;

use KodCube\Container\Container;
use Interop\Container\Exception\NotFoundException;
use KodCube\Container\Test\Mocks;

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
