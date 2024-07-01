<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Salary;
use App\Models\Employee;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class EmployeeController extends Controller
{
    //

    public function index(Request $request){


        if($request->ajax()){
            $data = Employee::all();
            return Datatables::of($data)
                ->addColumn('image', function($row){
                    // if($row->image == null){
                    //     $return ''
                    // }
                    return '<img class="employee-image" src="'.$row->image.'" alt="">';
                })
                ->addColumn('name', function($row){
                    return '<h1 class="name">'.$row->first_name.' '.$row->middle_name.' '.$row->last_name.'</h1>
                            <p class="id">'.$row->employee_id.'</p>';
                })->addColumn('attendance', function($row){
                    $currentDate = Carbon::now();

                    $startOfWeek = $currentDate->startOfWeek();
                    $daysOfWeek = [];
                    for ($i = -1; $i < 6; $i++) {
                        // Log::info( $startOfWeek->copy()->addDays($i)->format('l'));
                        $daysOfWeek[] = $startOfWeek->copy()->addDays($i)->format('Y-m-d');
                        $daysOfname[] = $startOfWeek->copy()->addDays($i)->format('l');
                    }
                    $employee_id = $row->employee_id;
                    $attendances = Attendance::where('employee_id', $employee_id)
                                    ->whereIn('date', $daysOfWeek)
                                    ->pluck('date');
                    $html = '<div class="week-attendance">';

                    foreach ($daysOfWeek as $index => $day) {
                        $dayName = $daysOfname[$index];
                        $date = Carbon::parse($day);
                        if ($date->isFuture()) {
                            $html .= '<div class="blank-box">';
                        } else {
                            $statusClass = $attendances->contains($day) ? 'green-box' : 'red-box';

                            $html .= '<div class="day-box ' . $statusClass . '">';

                        }
                        // $html .= '<span class="day-name">' . $dayName . '</span>';
                        $html .= '</div>';
                    }

                    $html .= '</div>';

                    return $html;
                }) ->addColumn('salary', function($row){
                    $totalSalary = $this->totalWeeklySalary($row->employee_id);
                    return '₱ '.number_format($totalSalary, 2, '.', ',');
                })->addColumn('daily_rate', function($row){
                    return '₱ '.number_format($row->daily_rate, 2, '.', ',');
                })->rawColumns(['name', 'image', 'attendance'])
                ->make(true);
        }
        return view('table/employee-table')
                ->with('Title', 'Employee Lists')
                ->with('user', Auth::user());
    }

    public function add(){
        return view('employee/add')
        ->with('Title', 'Add Employee')
        ->with('user', Auth::user());
    }

    public function create(Request $request) {
        Log::info($request);
        try {
            $validatedData = $request->validate([
                'employee_id' => 'required|integer',
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'middle_name' => 'nullable|string',
                'position' => 'required|string',
                'job_type' => 'required|string',
                'date-hired' => 'required|date',
                'start-date' => 'required|date',
                'supervisor' => 'required|string',
                'daily-rate' => 'required|numeric',
                'cab' => 'required|numeric',
                'birth' => 'required|date',
                'nationality' => 'required|string',
                'gender' => 'required|string',
                'contact_number' => 'required|string',
                'email' => 'required|email',
                'address' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
                'file_upload' => 'nullable',
            ]);
            Log::info($validatedData);
            if ($request->hasFile('image')) {
                $fileName = time().$request->file('image')->getClientOriginalName();
                $path = $request->file('image')->storeAs('images', $fileName, 'public');
                $validatedData["image"] = '/storage/'.$path;
            }

            if ($request->hasFile('file_upload')) {
                $fileName = time().$request->file('file_upload')->getClientOriginalName();
                $path = $request->file('file_upload')->storeAs('file', $fileName, 'public');
                $validatedData["file_upload"] = '/storage/'.$path;
            }


            $existingEmployee = Employee::where('employee_id', $validatedData['employee_id'])->first();
            if ($existingEmployee) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Employee ID already exists'
                ]);
            }

            $existingEmployee = Employee::where('contact_number', $validatedData['contact_number'])->first();
            if ($existingEmployee) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Contact Number already exists'
                ]);
            }

            $existingEmployee = Employee::where('email', $validatedData['email'])->first();
            if ($existingEmployee) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Email already exists'
                ]);
            }

            $employee = new Employee();

            $employee->employee_id = $validatedData['employee_id'];
            $employee->first_name = $validatedData['first_name'];
            $employee->last_name = $validatedData['last_name'];
            $employee->middle_name = $validatedData['middle_name'];
            $employee->position = $validatedData['position'];
            $employee->job_type = $validatedData['job_type'];
            $employee->hired_date = $validatedData['date-hired'];
            $employee->start_date = $validatedData['start-date'];
            $employee->supervisor = $validatedData['supervisor'];
            $employee->daily_rate = $validatedData['daily-rate'];
            $employee->cash_advance = $validatedData['cab'];
            $employee->birthdate = $validatedData['birth'];
            $employee->nationality = $validatedData['nationality'];
            $employee->gender = $validatedData['gender'];
            $employee->contact_number = $validatedData['contact_number'];
            $employee->email = $validatedData['email'];
            $employee->address = $validatedData['address'];
            $employee->file_upload = $validatedData['file_upload'] ?? null;
            $employee->image = $validatedData['image'] ?? null;
            $employee->save();
            Log::info('Employee saved successfully: ' . $employee->id);

            return response()->json([
                'status' => 'success',
                'message' => 'Employee saved successfully: ' . $employee->id
            ]);
        } catch (QueryException $e) {
            Log::error('Query Exception occurred while saving employee: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error in saving employee data'
            ]);
            return response()->json(['errors' =>  $e->getMessage()]);
        } catch (\Exception $e) {
            Log::error('Exception occurred while saving employee: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error in saving employee data'
            ]);
        }
    }

    public function show($id){
        $employee = Employee::findOrFail($id);
        // return $employee;
        $totalSalary = number_format($this->totalWeeklySalary($employee->employee_id), 2, '.', ',');
        $totalWeekly = number_format($this->weeklySalary($employee->employee_id), 2, '.', ',');
        $totalOT = number_format($this->totalWeeklyOT($employee->employee_id), 2, '.', ',');

        $currentDate = Carbon::now();
        $startOfWeek =(clone $currentDate)->startOfWeek()->addDays(-1)->format('Y-m-d');
        $endOfWeek = (clone $currentDate)->startOfWeek()->addDays(5)->format('Y-m-d');
        $salary = Salary::where('employee_id', $employee->employee_id)
                                ->where('from', '<=', $startOfWeek)
                                ->where('to', '>=', $endOfWeek)
                                ->first();

        return view('employee/show', compact('employee','totalSalary', 'totalOT', 'totalWeekly', 'salary'))
                ->with('Title', 'Employee Details')
                ->with('user', Auth::user());
    }

    public function edit(Request $request){
        $employee = Employee::findOrFail($request->id);

        return view('employee/edit', compact('employee'))
                ->with('Title', 'Edit Details')
                ->with('user', Auth::user());
    }
    public function saveEdit(Request $request){
        Log::info($request);
        try {
            $validatedData = $request->validate([
                'id' => 'required',
                'employee_id' => 'required|integer',
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'middle_name' => 'nullable|string',
                'position' => 'required|string',
                'job_type' => 'required|string',
                'date-hired' => 'required|date',
                'start-date' => 'required|date',
                'supervisor' => 'required|string',
                'daily-rate' => 'required|numeric',
                'cab' => 'required|numeric',
                'birth' => 'required|date',
                'nationality' => 'required|string',
                'gender' => 'required|string',
                'contact_number' => 'required|string',
                'email' => 'required|email',
                'address' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
                'file_upload' => 'nullable',
            ]);
            Log::info($validatedData);
            if ($request->hasFile('image')) {
                $fileName = time().$request->file('image')->getClientOriginalName();
                $path = $request->file('image')->storeAs('images', $fileName, 'public');
                $validatedData["image"] = '/storage/'.$path;
            }

            if ($request->hasFile('file_upload')) {
                $fileName = time().$request->file('file_upload')->getClientOriginalName();
                $path = $request->file('file_upload')->storeAs('file', $fileName, 'public');
                $validatedData["file_upload"] = '/storage/'.$path;
            }


            $existingEmployee = Employee::where('employee_id', $validatedData['employee_id'])
                                        ->where('id', '!=', $validatedData['id'])
                                        ->first();
            if ($existingEmployee) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Employee ID already exists'
                ]);
            }

            $existingEmployee = Employee::where('contact_number', $validatedData['contact_number'])
                                        ->where('id', '!=', $validatedData['id'])->first();
            if ($existingEmployee) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Contact Number already exists'
                ]);
            }

            $existingEmployee = Employee::where('email', $validatedData['email'])
                                    ->where('id', '!=', $validatedData['id'])->first();

            if ($existingEmployee) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Email already exists'
                ]);
            }

            $employee = Employee::where('id', $validatedData['id'])->first();

            $employee->employee_id = $validatedData['employee_id'];
            $employee->first_name = $validatedData['first_name'];
            $employee->last_name = $validatedData['last_name'];
            $employee->middle_name = $validatedData['middle_name'];
            $employee->position = $validatedData['position'];
            $employee->job_type = $validatedData['job_type'];
            $employee->hired_date = $validatedData['date-hired'];
            $employee->start_date = $validatedData['start-date'];
            $employee->supervisor = $validatedData['supervisor'];
            $employee->daily_rate = $validatedData['daily-rate'];
            $employee->cash_advance = $validatedData['cab'];
            $employee->birthdate = $validatedData['birth'];
            $employee->nationality = $validatedData['nationality'];
            $employee->gender = $validatedData['gender'];
            $employee->contact_number = $validatedData['contact_number'];
            $employee->email = $validatedData['email'];
            $employee->address = $validatedData['address'];
            if (isset($validatedData['file_upload'])) {
                $employee->file_upload = $validatedData['file_upload'];
            }

            if (isset($validatedData['image'])) {
                $employee->image = $validatedData['image'];
            }

            $employee->save();
            Log::info('Employee saved successfully: ' . $employee->id);

            return response()->json([
                'status' => 'success',
                'message' => 'Employee saved successfully: ' . $employee->id
            ]);
        } catch (QueryException $e) {
            Log::error('Query Exception occurred while saving employee: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error in saving employee data'
            ]);
            return response()->json(['errors' =>  $e->getMessage()]);
        } catch (\Exception $e) {
            Log::error('Exception occurred while saving employee: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error in saving employee data'
            ]);
        }
    }

    public function totalWeeklySalary($employee_id){
        $currentDate = Carbon::now();
        $startOfWeek =(clone $currentDate)->startOfWeek()->addDays(-1)->format('Y-m-d');
        $endOfWeek = (clone $currentDate)->startOfWeek()->addDays(5)->format('Y-m-d');

        $employee = Employee::where('employee_id', $employee_id)->first();
        $salary = Salary::where('employee_id', $employee_id)
                                ->where('from', $startOfWeek)
                                ->where('to', $endOfWeek)
                                ->first();

        $perHourRate = (float)($employee->daily_rate / 8);

        $columns = [
            'sunday', 'sunday_ot',
            'monday', 'monday_ot',
            'tuesday', 'tuesday_ot',
            'wednesday', 'wednesday_ot',
            'thursday', 'thursday_ot',
            'friday', 'friday_ot',
            'saturday', 'saturday_ot'
        ];

        $totalSalary = 0;
        $results = [];

        if ($salary) {
            foreach ($columns as $column) {
                $hours = $salary->$column;
                $computedValue = $hours !== null ? $hours * $perHourRate : 0;
                $results[$column] = $computedValue;
                $totalSalary += $computedValue;
            }
        }

        return $totalSalary;
    }

    public function totalWeeklyOT($employee_id){
        $currentDate = Carbon::now();
        $startOfWeek =(clone $currentDate)->startOfWeek()->addDays(-1)->format('Y-m-d');
        $endOfWeek = (clone $currentDate)->startOfWeek()->addDays(5)->format('Y-m-d');

        $employee = Employee::where('employee_id', $employee_id)->first();
        $salary = Salary::where('employee_id', $employee_id)
                                ->where('from', $startOfWeek)
                                ->where('to', $endOfWeek)
                                ->first();

        $perHourRate = (float)($employee->daily_rate / 8);

        $columns = [
            'sunday_ot',
            'monday_ot',
            'tuesday_ot',
            'wednesday_ot',
            'thursday_ot',
            'friday_ot',
            'saturday_ot'
        ];

        $totalOT = 0;
        $results = [];

        if ($salary) {
            foreach ($columns as $column) {
                $hours = $salary->$column;
                $computedValue = $hours !== null ? $hours * $perHourRate : 0;
                $results[$column] = $computedValue;
                $totalOT += $computedValue;
            }
        }

        return $totalOT;
    }

    public function weeklySalary($employee_id){
        $currentDate = Carbon::now();
        $startOfWeek =(clone $currentDate)->startOfWeek()->addDays(-1)->format('Y-m-d');
        $endOfWeek = (clone $currentDate)->startOfWeek()->addDays(5)->format('Y-m-d');

        $employee = Employee::where('employee_id', $employee_id)->first();
        $salary = Salary::where('employee_id', $employee_id)
                                ->where('from', $startOfWeek)
                                ->where('to', $endOfWeek)
                                ->first();

        $perHourRate = (float)($employee->daily_rate / 8);

        $columns = [
            'sunday',
            'monday',
            'tuesday',
            'wednesday',
            'thursday',
            'friday',
            'saturday'
        ];

        $totalOT = 0;
        $results = [];

        if ($salary) {
            foreach ($columns as $column) {
                $hours = $salary->$column;
                $computedValue = $hours !== null ? $hours * $perHourRate : 0;
                $results[$column] = $computedValue;
                $totalOT += $computedValue;
            }
        }

        return $totalOT;
    }
}
