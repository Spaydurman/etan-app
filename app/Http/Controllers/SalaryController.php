<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Salary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SalaryController extends Controller
{
    public function deduct(Request $request){
        // return $request;
        $request->validate([
            'cad' => 'numeric | nullable',
            'meals' => 'numeric | nullable',
            'sss' => 'numeric | nullable',
            'philhealth' => 'numeric | nullable',
            'tax' => 'numeric | nullable',
            'others' => 'numeric | nullable',
            'employee_id' => 'required'
        ]);


        $fields = ['cad', 'meals', 'sss', 'philhealth', 'tax', 'others'];
        $allNull = true;

        foreach ($fields as $field) {
            if (!is_null($request->input($field))) {
                $allNull = false;
                break;
            }
        }

        if ($allNull) {
            return response()->json([
                'status' => 'error',
                'message' => 'Please place value in any text field before saving!'
            ]);
        }

        try{
            $currentDate = Carbon::now();
            $startOfWeek =(clone $currentDate)->startOfWeek()->addDays(-1)->format('Y-m-d');
            $endOfWeek = (clone $currentDate)->startOfWeek()->addDays(5)->format('Y-m-d');

            $existingRecord = Salary::where('employee_id', $request->employee_id)
                                    ->where('from', '<=', $startOfWeek)
                                    ->where('to', '>=', $endOfWeek)
                                    ->first();


            if ($existingRecord) {

                $data = [
                    'cash_advance' => $request->cad ,
                    'meals' => $request->meals,
                    'sss' => $request->sss,
                    'phil_health' => $request->philhealth,
                    'tax' => $request->tax,
                    'others' => $request->others
                ];

                $data['cash_advance'] += $existingRecord->cash_advance ?? 0;
                $data['meals'] += $existingRecord->meals ?? 0;
                $data['sss'] += $existingRecord->sss ?? 0;
                $data['phil_health'] += $existingRecord->phil_health ?? 0;
                $data['tax'] += $existingRecord->tax ?? 0;
                $data['others'] += $existingRecord->others ?? 0;

                if(Salary::where('employee_id', $request->employee_id)
                    ->where('from', $startOfWeek)
                    ->where('to', $endOfWeek)
                    ->update($data)){

                    Log::info('Salary Deduction | Success Saving |');
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Salary Deduction saved successfully'
                    ]);
                }else{
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Error in saving employee data'
                    ]);
                }
            }

        }catch(Exception $e){

            Log::info('Salary Deduction | Error | '.$e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error in saving employee data'
            ]);
        }


    }
}
