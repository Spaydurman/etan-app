<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;

    protected $table = 'salary';
    protected $fillable = [
        'employee_id',
        'sunday',
        'sunday_ot',
        'monday',
        'monday_ot',
        'tuesday',
        'tuesday_ot',
        'wednesday',
        'wednesday_ot',
        'thursday',
        'thursday_ot',
        'friday',
        'friday_ot',
        'saturday',
        'saturday_ot',
        'cash_advance',
        'sss',
        'phil_health',
        'tax',
        'meals',
        'others',
        'from',
        'to'
    ];
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'employee_id');
    }
}
