<?php

namespace Tests\Feature;

use Tests\TestCase;

class StartProductionTest extends TestCase
{
    /**
     * Test that the core classes can be instantiated without errors.
     */
    public function test_classes_can_be_instantiated()
    {
        // Test Machine instantiation
        $machine = new \App\Production\Machine('Test Machine');
        $this->assertInstanceOf(\App\Production\Machine::class, $machine);
        $this->assertEquals('Test Machine', $machine->name);

        // Test Employee instantiation
        $employee = new \App\Production\Employee('Test Employee', 'Test Role');
        $this->assertInstanceOf(\App\Production\Employee::class, $employee);
        $this->assertEquals('Test Employee', $employee->name);
        $this->assertEquals('Test Role', $employee->role);
    }

    /**
     * Test the observer pattern implementation.
     */
    public function test_observer_pattern_works()
    {
        $machine = new \App\Production\Machine('Test Machine');
        $employee = new \App\Production\Employee('Test Employee', 'Test Role');

        // Attach observer
        $machine->attach($employee);

        // Initially, state should be IDLE
        $this->assertEquals('IDLE', $machine->getState());

        // Set state to PRODUCING
        $machine->setState('PRODUCING');

        // Check that state was updated
        $this->assertEquals('PRODUCING', $machine->getState());
    }

}

