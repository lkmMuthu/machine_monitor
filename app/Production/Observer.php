<?php

namespace App\Production;

abstract class Observer
{
    public string $name;

    public function __construct( string $name )
    {
        $this->name = $name;
    }
    
    abstract public function update(string $state, string $machineName): void;
}