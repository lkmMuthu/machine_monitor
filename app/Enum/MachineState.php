<?php

namespace App\Enum;

enum MachineState:string {

    case PRODUCING = 'PRODUCING';
    case IDLE = 'IDLE';
    case STARVED = 'STARVED';

    public function color(): string
    {
        return match($this) {
            self::PRODUCING => 'green',
            self::IDLE => 'yellow',
            self::STARVED => 'red',
        };
    }
}
