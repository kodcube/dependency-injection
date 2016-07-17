<?php
namespace KodeCube\DependencyInjection\Test\UnitTest;

use KodeCube\DependencyInjection\Container;
use KodeCube\DependencyInjection\Exception\NotFoundException;
use KodeCube\DependencyInjection\Test\Mocks;

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
