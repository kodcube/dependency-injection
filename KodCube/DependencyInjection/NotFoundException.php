<?php
namespace KodCube\DependencyInjection;

use Psr\Container\NotFoundExceptionInterface;
use Exception;
use Throwable;
/**
 * @inheritdoc
 */   
class NotFoundException extends Exception implements Throwable, NotFoundExceptionInterface
{
    
}