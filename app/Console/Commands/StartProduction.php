<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Production\Machine;
use App\Production\Employee;
use App\Production\Dashboard;
use App\Enum\MachineState;

class StartProduction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:start-production';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the production monitoring simulation';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $this->info('Starting production monitoring simulation...');

            //Sample Machines
            $machines = [
                new Machine('Machine A'),
                new Machine('Machine B'),
                new Machine('Machine C'),
                new Machine('Machine D'),
                new Machine('Machine E'),
                new Machine('Machine F'),
                new Machine('Machine G')
            ];

            //Sample Employees
            $employee1 = new Employee('Alex', 'Production Manager');
            $employee2 = new Employee('Shaun', 'Techinician');

            //Attach observers for machines
            foreach ($machines as $machine) {
                // Everyone watches every machine for this demo
                $machine->attach($employee1);
                $machine->attach($employee2);
            }

            $this->info("Simulating machine state changes...\n");
            $this->info('Press Ctrl+C to stop at any time.' . "\n");

            while (true) {
                    try {
                        $states = MachineState::cases();
                        $randomState = $states[array_rand($states)];
                        $machine = $machines[array_rand($machines)];

                        //set random state for a random machine
                        $machine->setState($randomState->value);
                        $this->info("Set {$machine->name} to state: {$randomState->value}");
                    } catch (\Throwable $e) {
                        $this->error("Error setting state for machine {$machine->name}: " . $e->getMessage());
                    }

                sleep(3); // Wait for 3 seconds between state changes
            }
        } catch (\Throwable $e) {
            $this->error('An error occurred during simulation setup: ' . $e->getMessage());
            return 1; 
        }
    }
}
