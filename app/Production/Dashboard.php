<?php

namespace App\Production;

use App\Events\MachineStateUpdated;

class Dashboard extends Observer
{
    public function __construct()
    {
        parent::__construct('Dashboard');
    }

    public function update(string $state, string $from): void
    {
        echo " Dashboard notified message: Machine '{$from}' changed state to '{$state}'.\n";

        //emit event to websocket listeners
        MachineStateUpdated::dispatch($from, $state);

    }
}