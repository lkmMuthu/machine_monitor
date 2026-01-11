<?php

namespace App\Production;

abstract class Observer
{
    public string $name;

    /**
     * Constructor for Observer.
     *
     * @param string $name The name of the observer.
     */
    public function __construct( string $name )
    {
        $this->name = $name;
    }
    
    /**
     * Update method called when a machine changes state.
     *
     * @param string $state The new state of the machine.
     * @param string $machineName The name of the machine that changed state.
     * @return void
     */
    abstract public function update(string $state, string $machineName): void;
}