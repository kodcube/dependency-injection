<?php
namespace KodCube\Container\Test\Mocks;


class ClassMissingDependency
{
    public function __construct(MissingClassInterface $obj)
    {
    }
}