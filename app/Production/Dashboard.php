<?php

namespace App\Production;

use App\Events\MachineStateUpdated;

class Dashboard extends Observer
{
    public function __construct()
    {
        parent::__construct('Dashboard');
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
        echo " Dashboard notified message: Machine '{$from}' changed state to '{$state}'.\n";

        //emit event to websocket listeners
        MachineStateUpdated::dispatch($from, $state);

    }
}