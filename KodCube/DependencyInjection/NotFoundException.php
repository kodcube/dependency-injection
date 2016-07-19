<?php
namespace KodCube\DependencyInjection;

use Interop\Container\Exception\NotFoundException AS NotFoundExceptionInterface;
use Exception;
use Throwable;
/**
 * @inheritdoc
 */   
class NotFoundException extends Exception 
                        implements Throwable,
                                   NotFoundExceptionInterface
{
    
}