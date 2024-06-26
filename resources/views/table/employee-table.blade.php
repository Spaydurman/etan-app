@section('css')
    <link rel="stylesheet" href="{{ asset('css/list.css') }}">
@endsection
@extends('layout')

@section('contents')

    <section class="content-section">
        <div class="import-export">
            <button type="" class="edit btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M21 14a1 1 0 0 0-1 1v4a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-4a1 1 0 0 0-2 0v4a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3v-4a1 1 0 0 0-1-1m-9.71 1.71a1 1 0 0 0 .33.21a.94.94 0 0 0 .76 0a1 1 0 0 0 .33-.21l4-4a1 1 0 0 0-1.42-1.42L13 12.59V3a1 1 0 0 0-2 0v9.59l-2.29-2.3a1 1 0 1 0-1.42 1.42Z"/></svg>
                Import
            </button>
            <button type="" class="edit btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M8.71 7.71L11 5.41V15a1 1 0 0 0 2 0V5.41l2.29 2.3a1 1 0 0 0 1.42 0a1 1 0 0 0 0-1.42l-4-4a1 1 0 0 0-.33-.21a1 1 0 0 0-.76 0a1 1 0 0 0-.33.21l-4 4a1 1 0 1 0 1.42 1.42M21 14a1 1 0 0 0-1 1v4a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-4a1 1 0 0 0-2 0v4a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3v-4a1 1 0 0 0-1-1"/></svg>
                Export
            </button>
        </div>
        <div class="table">
            <table class="employee-table" id="employee-table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Employee Name</th>
                        <th>Position</th>
                        <th>Job Type</th>
                        <th>Supervisor</th>
                        <th>Contact Number</th>
                        <th>Email</th>
                        <th>Date Hired</th>
                        <th>Attendance</th>
                    </tr>
                </thead>
            </table>
        </div>
    </section>
@endsection
@section('script')
<script type="text/javascript">
    $(function () {
        $('#employee-table').DataTable().destroy();
        var table = $('#employee-table').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            scrollX: '100%',
            ajax: "{{ route('employee-dashboard') }}",
            columns: [
                {data: 'image', name: 'image'},
                {data: 'name', name: 'name'},
                {data: 'position', name: 'position'},
                {data: 'job_type', name: 'job_type'},
                {data: 'supervisor', name: 'supervisor'},
                {data: 'contact_number', name: 'contact_number'},
                {data: 'email', name: 'email'},
                {data: 'hired_date', name: 'hired_date'},
                {data: 'attendance', name: 'attendance'},
            ],
            createdRow: function(row, data, dataIndex) {
                $(row).on('click', function() {
                    // Assuming 'id' is a unique identifier in your data
                    var employeeId = data.id;
                    // Redirect to the details page
                    console.log(employeeId);
                    window.location.href = '/employee/details/' + employeeId;
                });
            }
        });
    });
    </script>
@endsection
