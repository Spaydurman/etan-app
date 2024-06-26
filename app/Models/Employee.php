<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'first_name',
        'last_name',
        'middle_name',
        'position',
        'job_type',
        'hired_date',
        'start_date',
        'supervisor',
        'daily_rate',
        'cash_advance',
        'birthdate',
        'nationality',
        'gender',
        'contact_number',
        'email',
        'address',
        'image',
        'file_upload',
    ];
}
