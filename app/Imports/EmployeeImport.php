<?php

namespace App\Imports;

use DateTime;
use Carbon\Carbon;
use App\Models\Salary;
use App\Models\Employee;
use App\Models\Attendance;
use Illuminate\Validation\Rule;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use PhpOffice\PhpSpreadsheet\Shared\Date as PhpSpreadsheetDate;

class EmployeeImport implements ToModel, WithHeadingRow, SkipsOnError
{
    use Importable, SkipsErrors;

    public function model(array $row)
    {
        if (empty($row['employee_id']) || empty($row['first_name']) || empty($row['last_name'])) {
            return null;
        }

        $row['date_of_birth'] = Date::excelToDateTimeObject($row['date_of_birth'])->format('Y-m-d');
        $row['date_hired'] = Date::excelToDateTimeObject($row['date_hired'])->format('Y-m-d');
        $row['start_date'] = Date::excelToDateTimeObject($row['start_date'])->format('Y-m-d');
        Log::info($row);
        $validator = Validator::make($row, [
            'employee_id' => 'required|unique:employees,employee_id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'date_of_birth' => 'required|date',
            'nationality' => 'required|string|max:255',
            'gender' => 'required|string|max:10',
            'contact_number' => 'required|unique:employees,contact_number',
            'email' => 'required|email|max:255|unique:employees,email',
            'address' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'job_type' => 'required|string|max:255',
            'date_hired' => 'required|date',
            'start_date' => 'required|date',
            'supervisor' => 'required|string|max:255',
            'daily_rate' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            throw ValidationException::withMessages([
                'employee_id' => 'Error found for Employee ID '. $row['employee_id'] . ': ' . implode(', ', $messages)
            ]);
        }

        $data = [
            'employee_id' => $row['employee_id'],
            'first_name' => $row['first_name'],
            'last_name' => $row['last_name'],
            'middle_name' => $row['middle_name'],
            'birthdate' =>  $row['date_of_birth'],
            'nationality' => $row['nationality'],
            'gender' => $row['gender'],
            'contact_number' => $row['contact_number'],
            'email' => $row['email'],
            'address' => $row['address'],
            'position' => $row['position'],
            'job_type' => $row['job_type'],
            'hired_date' => $row['date_hired'],
            'start_date' => $row['start_date'],
            'supervisor' => $row['supervisor'],
            'daily_rate' => $row['daily_rate'],
            'cash_advance' => 0.00,
        ];

        Employee::create($data);

    }
    public function collection(Collection $collection)
    {
        //
    }
}
