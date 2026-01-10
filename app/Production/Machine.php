<?php

namespace App\Production;

use App\Enum\MachineState;

class Machine extends Subject
{

    public string $name;

    public function __construct(string $name)
    {
        parent::__construct();
        $this->name = $name;
        $this->state = MachineState::IDLE->value;
    }
}
