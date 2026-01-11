<?php

namespace App\Production;

use App\Enum\MachineState;

class Machine extends Subject
{

    public string $name;
    public string $state;

    /**
     * The current state of the machine.
     *
     * @var string
     */
    public function __construct(string $name)
    {
        parent::__construct();
        $this->name = $name;
        $this->state = MachineState::IDLE->value;
    }
}
