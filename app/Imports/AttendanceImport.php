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

class AttendanceImport implements ToModel, WithHeadingRow, SkipsOnError, WithValidation
{
    use Importable, SkipsErrors;

    public function model(array $row)
    {

        static $allDates = [];

        $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['date']);
        $formattedDate = $date->format('m/d/Y');
        $row['date'] = $formattedDate;


        $allDates[] = $formattedDate;

        if (count($allDates) > 1) {
            $firstDate = $allDates[0];
            foreach ($allDates as $date) {
                if ($date !== $firstDate) {
                    Log::error('Inconsistent date found: '. $row['employee_id']);
                    throw ValidationException::withMessages([
                        'Inconsistent date found for Employee ID '. $row['employee_id']
                    ]);
                }
            }
        }

        // Parse time_in and time_out
        $time_in = PhpSpreadsheetDate::excelToDateTimeObject($row['time_in']);
        $time_out = PhpSpreadsheetDate::excelToDateTimeObject($row['time_out']);

        $row['time_in'] = $time_in->format('H:i:s');
        $row['time_out'] = $time_out->format('H:i:s');

        $validator = Validator::make($row, [
            'employee_id' => ['required'],
            'name' => ['required'],
            'date' => ['required', 'date_format:m/d/Y'],
            'time_in' => ['nullable', 'date_format:H:i:s'],
            'time_out' => ['nullable', 'date_format:H:i:s'],
            'overtime' => ['nullable', 'numeric'],
        ]);

        if ($validator->fails()) {
            Log::error('Validation failed for row: ' . json_encode($row) . ' with errors: ' . $validator->errors()->toJson());
            throw ValidationException::withMessages([
                'Validation failed for Employee ID: ' . $row['employee_id'] . '. Please make sure the data are correct.'
            ]);
        }

        // Save the attendance data
        $attendance = Attendance::updateOrCreate(
            ['employee_id' => $row['employee_id'], 'date' => $row['date']],
            [
                'name' => $row['name'],
                'time_in' => $row['time_in'],
                'time_out' => $row['time_out'],
                'overtime' => $row['overtime'],
            ]
        );

        return $attendance;
    }

    public function rules(): array
    {
        return [
            '*.employee_id' => ['required'],
            '*.name' => ['required'],
            '*.date' => ['required' ],
            '*.time_in' => ['nullable'],
            '*.time_out' => ['nullable'],
            '*.overtime' => ['nullable', 'numeric'],
        ];
    }

    public function customValidationMessages()
    {
        return [
            'date.in' => 'Invalid date format',
        ];
    }

    public function prepareForValidation($row, $index)
    {
        if (!isset($row['employee_id']) || !isset($row['name']) || !isset($row['date']) ||
            !isset($row['time_in']) || !isset($row['time_out']) || !isset($row['overtime'])) {
            throw ValidationException::withMessages(['error' => 'Please upload correct format']);
        }

        return $row;
    }

}
