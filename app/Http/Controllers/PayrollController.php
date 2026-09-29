<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Payroll;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function index()
    {
        $payrolls = Payroll::with('employee')->latest()->paginate(15);
        $employees = Employee::where('is_active', true)->orderBy('name')->get();
        return view('payroll.index', compact('payrolls', 'employees'));
    }

    public function calculate(Request $request)
    {
        $data = $request->validate([
            'employee_id' => ['required', 'exists:employees,id'],
            'period_start' => ['required', 'date'],
            'period_end' => ['required', 'date', 'after_or_equal:period_start'],
        ]);

        $employee = Employee::findOrFail($data['employee_id']);

        $logs = $employee->attendances()
            ->whereBetween('log_time', [$data['period_start'] . ' 00:00:00', $data['period_end'] . ' 23:59:59'])
            ->orderBy('log_time')
            ->get()
            ->groupBy(fn ($log) => $log->log_time->toDateString());

        $totalHours = 0;
        $daysWorked = 0;

        foreach ($logs as $dayLogs) {
            $checkIn = $dayLogs->where('type', 0)->first();
            $checkOut = $dayLogs->where('type', 1)->last();

            if ($checkIn && $checkOut && $checkOut->log_time->gt($checkIn->log_time)) {
                $hours = $checkOut->log_time->diffInMinutes($checkIn->log_time) / 60;
                $totalHours += $hours;
                $daysWorked++;
            }
        }

        $gross = match ($employee->pay_type) {
            'hourly' => $totalHours * ($employee->hourly_rate ?? 0),
            'daily' => $daysWorked * ($employee->daily_rate ?? 0),
            'monthly' => $employee->monthly_rate ?? 0,
            default => 0,
        };

        $payroll = Payroll::updateOrCreate(
            [
                'employee_id' => $employee->id,
                'period_start' => $data['period_start'],
                'period_end' => $data['period_end'],
            ],
            [
                'days_worked' => $daysWorked,
                'total_hours' => round($totalHours, 2),
                'gross_pay' => $gross,
                'deductions' => 0,
                'net_pay' => $gross,
                'status' => 'pending',
            ]
        );

        return redirect()->route('payroll.index')->with('success', 'Payroll calculated / වැටුප ගණනය කරන ලදී');
    }

    public function markPaid(Payroll $payroll)
    {
        $payroll->update(['status' => 'paid']);
        return back()->with('success', 'Marked as paid');
    }

    public function destroy(Payroll $payroll)
    {
        $payroll->delete();
        return back()->with('success', 'Payroll record removed');
    }
}
