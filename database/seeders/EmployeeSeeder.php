<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Employee;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Employee::create([
            'name' => 'John Doe',
            'role' => 'Technician',
            'email' => 'john.doe@example.com',
            'employee_id' => 'EMP001'
        ]);

        Employee::create([
            'name' => 'Jane Smith',
            'role' => 'Supervisor',
            'email' => 'jane.smith@example.com',
            'employee_id' => 'EMP002'
        ]);

        Employee::create([
            'name' => 'Mike Johnson',
            'role' => 'Operator',
            'email' => 'mike.johnson@example.com',
            'employee_id' => 'EMP003'
        ]);
    }
}
