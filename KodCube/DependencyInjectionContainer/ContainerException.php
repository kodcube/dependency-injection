<?php
namespace KodCube\Container;

use Interop\Container\Exception\NotFoundException AS NotFoundExceptionInterface;
use Exception;
use Throwable;

/**
 * @inheritdoc
 */   
class ContainerException extends Exception 
                         implements Throwable,
                                    NotFoundExceptionInterface
{
    
}