<?php

namespace App\Http\Controllers;

use DateTime;
use Exception;
use Carbon\Carbon;
use App\Models\Salary;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Imports\AttendanceImport;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\ValidationException;

class AttendanceController extends Controller
{


    public function upload(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls',
        ], [
            'excel_file.required' => 'Please upload an excel file',
            'excel_file.mimes' => 'The file should be excel (xlsx, xls.)',
        ]);


        $file = $request->file('excel_file');
        try {
            Excel::import(new AttendanceImport(), $file);

            $this->salaryUpdate();
            return response()->json([
                'status' => 'success',
                'message' => 'Attendance uploaded successfully'
            ]);
            Log::info('Attendance uploaded successfully');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();

            $errors = collect($failures)->map(function ($failure) {
                return 'Row ' . $failure->row() . ': ' . $failure->errors()[0];
            });

            Log::info('Validation failed Excel: ' . $errors->implode('; '));
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed: ' . $errors->implode('; ')
            ]);
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->all();
            Log::info('Validation failed: ' . implode(', ', $errors));
            return response()->json([
                'status' => 'error',
                'message' => implode(', ', $errors)
            ]);
        } catch (Exception $e) {
            Log::info('An error occurred: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' =>  'An error occurred: ' . $e->getMessage(). '. Please try again'
            ]);
        }

        return redirect()->route('employee-dashboard')->with('success', 'Attendance imported successfully.');
    }

    public function salaryUpdate(){
        $lastDate = Attendance::orderBy('updated_at', 'desc')->first();
        $attendances = Attendance::where('date', $lastDate->date)->get();
        $currentDate = Carbon::now();
        foreach($attendances as $attendance){
            $startOfWeek =(clone $currentDate)->startOfWeek()->addDays(-1)->format('Y-m-d');
            $endOfWeek = (clone $currentDate)->startOfWeek()->addDays(5)->format('Y-m-d');
            $date = Carbon::parse($attendance->date);
            $dateName = strtolower($date->format('l'));

            $decimalHours = $this->calculateDecimalHours($attendance->time_in,  $attendance->time_out);

            if($decimalHours > 4 ){
                $decimalHours = $decimalHours - 1;
            }
            if($decimalHours > 8 ){
                $decimalHours = 8;
            }

            $dayColumn = $dateName;
            $otColumn = $dateName . '_ot';

            $data = [
                'employee_id' => $attendance->employee_id,
                $dayColumn => $decimalHours,
                $otColumn => $attendance->overtime,
                'from' => $startOfWeek,
                'to' => $endOfWeek,
            ];

            $existingRecord = Salary::where('employee_id', $attendance->employee_id)
                                ->where('from', '<=', $date)
                                ->where('to', '>=', $date)
                                ->first();

            if ($existingRecord) {
                Salary::where('employee_id', $attendance->employee_id)
                    ->where('from', $startOfWeek)
                    ->where('to', $endOfWeek)
                    ->update($data);
            } else {
                Salary::create($data);
            }
        }
    }
    public function calculateDecimalHours($startTime, $endTime)
    {
        $start = new DateTime($startTime);
        $end = new DateTime($endTime);

        $interval = $start->diff($end);

        $hours = $interval->h;
        $minutes = $interval->i;
        $seconds = $interval->s;

        $decimalHours = $hours + ($minutes / 60) + ($seconds / 3600);

        return $decimalHours;
    }
}
