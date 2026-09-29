<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $fillable = [
        'employee_id', 'period_start', 'period_end', 'days_worked',
        'total_hours', 'gross_pay', 'deductions', 'net_pay', 'status',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
