<?php
namespace KodeCube\DependencyInjection\Test\UnitTest;

use KodeCube\DependencyInjection\Container;
use Interop\Container\Exception\NotFoundException;
use KodeCube\DependencyInjection\Test\Mocks;

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
