<?php

namespace App\Production;

use Illuminate\Support\Facades\Log;
class Employee extends Observer
{
    public string $role;

    /**
     * Constructor for Employee.
     *
     * @param string $name The name of the employee.
     * @param string $role The role of the employee.
     */
    public function __construct(string $name, string $role)
    {
        parent::__construct($name);
        $this->role = $role;
    }

    /**
     * Update method called when a machine changes state.
     *
     * @param string $state The new state of the machine.
     * @param string $from The name of the machine that changed state.
     * @return void
     */

    public function update(string $state, string $from): void
    {
        Log::info(
            "Employee {$this->name} ({$this->role}) notified: Machine '{$from}' changed state to '{$state}'.\n"
        );
        echo "Employee {$this->name} ({$this->role}) notified: Machine '{$from}' changed state to '{$state}'.\n";
    }
}