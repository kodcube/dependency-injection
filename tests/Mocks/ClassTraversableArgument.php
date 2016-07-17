<?php
namespace KodCube\Container\Test\Mocks;

class ClassTraversableArgument
{
    public function __construct($args)
    {
        foreach ($args AS $key=>$argument) {
            $this->$key = $argument;
        }
    }
}