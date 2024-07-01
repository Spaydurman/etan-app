@section('css')
    <link rel="stylesheet" href="{{ asset('css/show.css') }}">
@endsection
@extends('layout')

@section('contents')

<section class="info-container">
    <section class="image-personal-info">
        <div class="image-total">
            <div class="image-con">
                @if ($employee->image != null)
                    <img src="{{$employee->image}}" alt="" id="preview" >
                @else
                    <svg id="default-svg" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M12 11.385q-1.237 0-2.119-.882T9 8.385t.881-2.12T12 5.386t2.119.88t.881 2.12t-.881 2.118t-2.119.882m-7 7.23V16.97q0-.619.36-1.158q.361-.54.97-.838q1.416-.679 2.834-1.018q1.417-.34 2.836-.34t2.837.34t2.832 1.018q.61.298.97.838q.361.539.361 1.158v1.646zm1-1h12v-.646q0-.332-.215-.625q-.214-.292-.593-.494q-1.234-.598-2.546-.916T12 14.616t-2.646.318t-2.546.916q-.38.202-.593.494Q6 16.637 6 16.97zm6-7.23q.825 0 1.413-.588T14 8.384t-.587-1.412T12 6.384t-1.412.588T10 8.384t.588 1.413t1.412.587m0 7.232"/></svg>
                @endif
            </div>
            <div class="employee-id">
                <p>Employee ID:  </p>
                <h1>{{$employee->employee_id}}</h1>
            </div>
            <div class="total-weekly">
                <h1>Total Weekly Salary</h1>
                <h1 class="weekly-salary">₱ {{$totalSalary}}</h1>

                <div class="run-down">
                    <div class="info-p">
                        <p>Weekly Salary:  </p>
                        <p>₱ {{$totalWeekly}}</p>
                    </div>
                    <div class="info-p">
                        <p>Overtime:  </p>
                        <p>₱ {{$totalOT}}</p>
                    </div>
                    <div class="info-p">
                        <p>CA Balance:  </p>
                        <p>₱ {{ number_format($salary->cash_advance ?? 0, 2) }}</p>
                    </div>
                    <div class="info-p">
                        <p>Meals:  </p>
                        <p>₱ {{ number_format($salary->meals ?? 0, 2) }}</p>
                    </div>
                    <div class="info-p sss">
                        <p>SSS:  </p>
                        <p>₱ {{ number_format($salary->sss ?? 0, 2) }}</p>
                    </div>
                    <div class="info-p">
                        <p>PhilHealth:  </p>
                        <p>₱ {{ number_format($salary->phil_health ?? 0, 2) }}</p>
                    </div>
                    <div class="info-p">
                        <p>Tax:  </p>
                        <p>₱ {{ number_format($salary->tax ?? 0, 2) }}</p>
                    </div>
                    <div class="info-p">
                        <p>Others:  </p>
                        <p>₱ {{ number_format($salary->others ?? 0, 2) }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="personal-contact-job">
            <div class="personal-contact-con">
                <div class="personal-con">
                    <h1>Personal Information</h1>
                    <div class="info-p">
                        <p>Name:  </p>
                        <p>{{$employee->first_name}} {{$employee->middle_name}} {{$employee->last_name}}</p>
                    </div>
                    <div class="info-p">
                        <p>Date of Birth:  </p>
                        <p>{{ \Carbon\Carbon::parse($employee->birthdate)->format('m/d/Y') }}</p>
                    </div>
                    <div class="info-p">
                        <p>Nationality:  </p>
                        <p>{{$employee->nationality}}</p>
                    </div>
                    <div class="info-p">
                        <p>Gender:  </p>
                        <p>{{$employee->gender}}</p>
                    </div>
                </div>
                <div class="contact-con">
                    <h1>Contact Information</h1>
                    <div class="info-p">
                        <p>Contact Number:  </p>
                        <p>{{$employee->contact_number}}</p>
                    </div>
                    <div class="info-p">
                        <p>Email:  </p>
                        <p>{{$employee->email}}</p>
                    </div>
                    <div class="info-p">
                        <p>Address:  </p>
                        <p>{{$employee->address}}</p>
                    </div>
                </div>
            </div>
            <div class="job-description">
                <h1>Job Description</h1>
                <div class="job-desc-details">
                    <div class="jd-1">
                        <div class="info-p">
                            <p>Position/Designation:  </p>
                            <p>{{$employee->position}}</p>
                        </div>
                        <div class="info-p">
                            <p>Job Type:  </p>
                            <p>{{$employee->job_type}}</p>
                        </div>
                        <div class="info-p">
                            <p>Date Hired:  </p>
                            <p>{{ \Carbon\Carbon::parse($employee->hired_date)->format('m/d/Y') }}</p>
                        </div>
                        <div class="info-p">
                            <p>Start Date:  </p>
                            <p>{{ \Carbon\Carbon::parse($employee->start_date)->format('m/d/Y') }}</p>
                        </div>
                    </div>
                    <div class="jd-2">
                        <div class="info-p">
                            <p>Supervisor:  </p>
                            <p>{{$employee->supervisor}}</p>
                        </div>
                        <div class="info-p">
                            <p>Daily Rate:  </p>
                            <p>₱ {{$employee->daily_rate}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="job-description">
                <h1>File Upload</h1>
            </div>
        </div>
        <div class="edit-con">
            <form action="{{ route('employee.edit') }}">
                @csrf
                <input type="hidden" name="id" value="{{$employee->id}}">
                <button type="submit" class="edit">Edit</button>
            </form>
        </div>
    </section>


    <section class="salary-deduction">
        <form action="{{ route('salary.deduct') }}" id="salary-deduct" method="POST">
            @csrf
            <div class="text-container">
                <h1>Salary Deduction</h1>
            </div>

            <div class="input-con">
                <div class="input">
                    <label for="cad">Cash Advance</label>
                    <input type="number" name="cad" id="cad" class="cash-advance" step="0.01" pattern="\d+(\.\d{1,2})?">
                </div>
                <div class="input">
                    <label for="meals">Meals</label>
                    <input type="number" name="meals" id="meals" class="meals" step="0.01" pattern="\d+(\.\d{1,2})?">
                </div>
                <div class="input">
                    <label for="sss">SSS</label>
                    <input type="number" name="sss" id="sss" class="sss" step="0.01" pattern="\d+(\.\d{1,2})?">
                </div>
            </div>
            <div class="input-con">
                <div class="input">
                    <label for="philhealth">PhilHealth </label>
                    <input type="number" name="philhealth" id="philhealth" class="philhealth" step="0.01" pattern="\d+(\.\d{1,2})?">
                </div>
                <div class="input">
                    <label for="tax">Tax</label>
                    <input type="number" name="tax" id="tax" class="tax" step="0.01" pattern="\d+(\.\d{1,2})?">
                </div>
                <div class="input">
                    <label for="others">Others</label>
                    <input type="number" name="others" id="others" class="others" step="0.01" pattern="\d+(\.\d{1,2})?">
                </div>
            </div>

            <div class="edit-con save-con">
                <div class="input">
                    <input type="hidden" name="employee_id" value="{{$employee->employee_id}}">
                </div>
                <button type="submit" class="edit save">Save</button>
            </div>
        </form>
    </section>
</section>
@endsection
@section('script')
    <script type="text/javascript" src="{{ asset('js/show.js') }}"></script>
@endsection
