<?php
namespace KodCube\DependencyInjection;

use Psr\Container\ContainerExceptionInterface;
use Exception;
use Throwable;

/**
 * @inheritdoc
 */   
class ContainerException extends Exception implements Throwable, ContainerExceptionInterface
{
    
}