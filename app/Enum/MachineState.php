<?php

namespace App\Enum;

enum MachineState:string {

    case PRODUCING = 'PRODUCING';
    case IDLE = 'IDLE';
    case STARVED = 'STARVED';

    public function color(): string
    {
        return match($this) {
            self::PRODUCING => '#0de43c',
            self::IDLE => '#e2d519',
            self::STARVED => '#b30505',
        };
    }
}
