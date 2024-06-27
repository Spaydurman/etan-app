<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;


    protected $table = 'attendance';

    protected $fillable = [
        'employee_id',
        'name',
        'date',
        'time-in',
        'time-out',
        'overtime',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'employee_id');
    }
}
