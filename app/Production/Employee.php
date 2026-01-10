<?php

namespace App\Production;

use Illuminate\Support\Facades\Log;
class Employee extends Observer
{
    public string $role;

    public function __construct(string $name, string $role)
    {
        parent::__construct($name);
        $this->role = $role;
    }



    public function update(string $state, string $from): void
    {
        Log::info(
            "Employee {$this->name} ({$this->role}) notified: Machine '{$from}' changed state to '{$state}'.\n"
        );
        echo "Employee {$this->name} ({$this->role}) notified: Machine '{$from}' changed state to '{$state}'.\n";
    }
}