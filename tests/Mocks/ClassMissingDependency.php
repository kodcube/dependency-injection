<?php
namespace KodCube\DependencyInjection\Test\Mocks;


class ClassMissingDependency
{
    public function __construct(MissingClassInterface $obj)
    {
    }
}