<?php

use Illuminate\Support\Facades\Route;
use App\Enum\MachineState;

Route::get('/', function () {
    return view('dashboard', [
        'stateColors' => [
            'PRODUCING' => MachineState::PRODUCING->color(),
            'IDLE' => MachineState::IDLE->color(),
            'STARVED' => MachineState::STARVED->color(),
        ]
    ]);
});
