<?php

namespace App\Http\Controllers;

use Exception;
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
}
