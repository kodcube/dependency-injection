<?php
namespace KodeCube\DependencyInjection\Test\Mocks;

class ClassMultipleArguments
{
    public function __construct(...$args)
    {
        foreach ($args AS $i=>$argument) {
            $this->{'argument'.$i} = $argument;
        }
    }
}