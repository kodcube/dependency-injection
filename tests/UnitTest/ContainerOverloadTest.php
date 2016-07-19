<?php
namespace KodCube\DependencyInjection\Test\UnitTest;

use KodCube\DependencyInjection\Container;
use Interop\Container\Exception\NotFoundException;
use KodCube\DependencyInjection\Test\Mocks;

class ContainerOverloadTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Check Alias to Class Map
     */
    public function testOverloadAlias()
    {
        $container = new Container(['MyAlias' => 'stdClass']);
        $container->MyAlias();
    }

    public function testOverloadAliasNotFound()
    {
        $this->setExpectedException(NotFoundException::class);

        $container = new Container();

        $container->ClassNotExist();

    }





}
