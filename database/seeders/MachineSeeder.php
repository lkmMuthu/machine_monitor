<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Machine;

class MachineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Machine::create([
            'name' => 'Machine A',
        ]);

        Machine::create([
            'name' => 'Machine B',
        ]);

        Machine::create([
            'name' => 'Machine C',
        ]);
    }
}
