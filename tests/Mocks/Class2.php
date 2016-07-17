<?php
namespace KodeCube\DependencyInjection\Test\Mocks;

class Class2
{
    public function __construct(...$args)
    {
        foreach ($args AS $i=>$argument) {
            $this->{'argument'.$i} = $argument;
        }
    }
}