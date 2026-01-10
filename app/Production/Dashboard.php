<?php

namespace App\Production;


class Dashboard extends Observer
{
    public function __construct()
    {
        parent::__construct('Dashboard');
    }

    public function update(string $state, string $from): void
    {
        echo "Employee {$this->name} ({$this->role}) notified: Machine '{$from}' changed state to '{$state}'.\n";

    }
}