<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Production\Machine;
use App\Production\Employee;
use App\Production\Dashboard;
use App\Enum\MachineState;
use App\Models\MachineAuditLog as MachineAuditLogModel;
use App\Models\Machine as MachineModel;

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
     * Execute the console command for starting the production monitoring simulation.
     * @return int
     */
    public function handle()
    {
        try {
            $this->info('Starting production monitoring simulation...');

            //Sample Machines
            $machines = [
                new Machine('Machine A'),
                new Machine('Machine B'),
                new Machine('Machine C')
            ];

            //Sample Employees
            $employee1 = new Employee('John Doe', 'Production Manager');
            $employee2 = new Employee('Jane Smith', 'Technician');

            //Dashboard
            $dashboard = new Dashboard();

            //Attach observers for machines
            foreach ($machines as $machine) {
                $machine->attach($employee1);
                $machine->attach($employee2);
                $machine->attach($dashboard);
            }

            $this->info("Simulating machine state changes...\n");
            $this->info('Press Ctrl+C to stop at any time.' . "\n");

            while (true) {
                    try {
                        $states = MachineState::cases();
                        $randomState = $states[array_rand($states)];
                        $machine = $machines[array_rand($machines)];

                        //set random state for a random machine
                        $previousState = $machine->getState();
                        $machine->setState($randomState->value);
                        $this->info("Set {$machine->name} to state: {$randomState->value}");

                        //add log to the table
                        $machineModel = MachineModel::where('name', $machine->name)->first();

                        if ($machineModel) {
                            MachineAuditLogModel::create([
                                'previous_state' => $previousState,
                                'new_state' => $randomState->value,
                                'machine_id' => $machineModel->id
                            ]);
                        }
                        
                    } catch (\Throwable $e) {
                        $this->error("Error setting state for machine {$machine->name}: " . $e->getMessage());
                    }

                //wait for 4 seconds before next change
                sleep(4);
            }
        } catch (\Throwable $e) {
            $this->error('An error occurred during simulation setup: ' . $e->getMessage());
            return 1;
        }
    }
}
