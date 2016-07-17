<?php
namespace KodCube\Container\Test\Mocks;

class Class1
{
    public function __construct(...$args)
    {
        foreach ($args AS $i=>$argument) {
            $this->{'argument'.$i} = $argument;
        }
    }
}