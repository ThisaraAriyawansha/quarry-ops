<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Attendance::with('employee')->latest('log_time');

        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }
        if ($request->filled('date')) {
            $query->whereDate('log_time', $request->date);
        }

        $attendances = $query->paginate(25);
        $employees = Employee::orderBy('name')->get();

        return view('attendance.index', compact('attendances', 'employees'));
    }

    // Manual attendance marking (used until the RFID/ADMS device is connected)
    public function storeManual(Request $request)
    {
        $data = $request->validate([
            'employee_id' => ['required', 'exists:employees,id'],
            'type' => ['required', 'in:0,1'], // 0 = check-in, 1 = check-out
        ]);

        Attendance::create([
            'employee_id' => $data['employee_id'],
            'log_time' => now(),
            'method' => 'manual',
            'type' => $data['type'],
        ]);

        return back()->with('success', 'Attendance marked / පැමිණීම සටහන් කරන ලදී');
    }
}
