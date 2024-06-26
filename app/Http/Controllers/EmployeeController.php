<?php

namespace App\Http\Controllers;

use Exception;
use Yajra\DataTables\DataTables;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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
                    return ' 6/7 ';
                })->rawColumns(['name', 'image'])
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
        return view('employee/show', compact('employee'))
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
}
