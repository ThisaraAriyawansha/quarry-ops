<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Attendance;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class EmployeeDemoSeeder extends Seeder
{
    public function run(): void
    {
        $employee1 = Employee::firstOrCreate(
            ['device_user_id' => '1001'],
            [
                'name' => 'Sunil Perera',
                'nic' => '901234567V',
                'phone' => '0771234567',
                'rfid_card_no' => 'CARD-1001',
                'pay_type' => 'daily',
                'daily_rate' => 2500,
                'is_active' => true,
            ]
        );

        $employee2 = Employee::firstOrCreate(
            ['device_user_id' => '1002'],
            [
                'name' => 'Kamal Silva',
                'nic' => '881234567V',
                'phone' => '0777654321',
                'rfid_card_no' => 'CARD-1002',
                'pay_type' => 'daily',
                'daily_rate' => 2800,
                'is_active' => true,
            ]
        );

        // Demo attendance for the last 5 days so payroll calculation has data to show
        foreach (range(4, 0) as $daysAgo) {
            $date = Carbon::today()->subDays($daysAgo);

            foreach ([$employee1, $employee2] as $employee) {
                Attendance::firstOrCreate([
                    'employee_id' => $employee->id,
                    'log_time' => $date->copy()->setTime(7, 30),
                ], [
                    'method' => 'rfid',
                    'type' => 0,
                ]);

                Attendance::firstOrCreate([
                    'employee_id' => $employee->id,
                    'log_time' => $date->copy()->setTime(17, 0),
                ], [
                    'method' => 'rfid',
                    'type' => 1,
                ]);
            }
        }
    }
}
