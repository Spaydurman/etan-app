@section('css')
    <link rel="stylesheet" href="{{ asset('css/list.css') }}">
@endsection
@extends('layout')

@section('contents')

    <section class="content-section">
        <div class="import-export">
            <button type="button" id="importButton" class="edit btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M8.71 7.71L11 5.41V15a1 1 0 0 0 2 0V5.41l2.29 2.3a1 1 0 0 0 1.42 0a1 1 0 0 0 0-1.42l-4-4a1 1 0 0 0-.33-.21a1 1 0 0 0-.76 0a1 1 0 0 0-.33.21l-4 4a1 1 0 1 0 1.42 1.42M21 14a1 1 0 0 0-1 1v4a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-4a1 1 0 0 0-2 0v4a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3v-4a1 1 0 0 0-1-1"/></svg>
                Attendance
            </button>
            <button type="" class="edit btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M21 14a1 1 0 0 0-1 1v4a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-4a1 1 0 0 0-2 0v4a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3v-4a1 1 0 0 0-1-1m-9.71 1.71a1 1 0 0 0 .33.21a.94.94 0 0 0 .76 0a1 1 0 0 0 .33-.21l4-4a1 1 0 0 0-1.42-1.42L13 12.59V3a1 1 0 0 0-2 0v9.59l-2.29-2.3a1 1 0 1 0-1.42 1.42Z"/></svg>
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
                        <th>Daily Rate (₱) </th>
                        <th>Current Salary (₱) </th>
                    </tr>
                </thead>
            </table>
        </div>
    </section>

    <section class="import-attendance">
        <form action="{{ route('attendance-upload') }}" id="attendance-upload-form" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="file-upload">
                <h1>Attendance Import</h1>
                <button type="button" class="close-import-attendance"> x </button>
                <div id="drop-area" class="drop-area" ondrop="dropHandler(event);" ondragover="dragOverHandler(event);">
                    <div id="show_file" style="display: none;">
                        <p id="uploadedFileName"></p>
                    </div>
                    <svg id="uploadIcon" class="upload-icon" xmlns="http://www.w3.org/2000/svg" width="1.15em" height="1em" viewBox="0 0 16 14"><path fill="currentColor" d="M12 11c-.28 0-.5-.22-.5-.5s.22-.5.5-.5c1.65 0 3-1.35 3-3s-1.35-3-3-3h-1.05c-.18 0-.34-.09-.43-.25C9.88 2.65 8.76 2 7.51 2c-1.93 0-3.5 1.57-3.5 3.5c0 .28-.22.5-.5.5h-.5c-1.1 0-2 .9-2 2s.9 2 2 2c.28 0 .5.22.5.5s-.22.5-.5.5c-1.65 0-3-1.35-3-3s1.35-3 3-3h.03c.25-2.25 2.16-4 4.47-4c1.49 0 2.89.76 3.72 2h.78c2.21 0 4 1.79 4 4s-1.79 4-4 4Z"/><path fill="currentColor" d="M10 9.25a.47.47 0 0 1-.35-.15L7.5 6.95L5.35 9.1c-.2.2-.51.2-.71 0s-.2-.51 0-.71l2.5-2.5c.2-.2.51-.2.71 0l2.5 2.5c.2.2.2.51 0 .71c-.1.1-.23.15-.35.15"/><path fill="currentColor" d="M7.5 13c-.28 0-.5-.22-.5-.5v-6c0-.28.22-.5.5-.5s.5.22.5.5v6c0 .28-.22.5-.5.5"/></svg>
                    <p class="upload-text">Drag and drop Excel files here <br> or <br> <a id="browseButton" class="browse" onclick="document.getElementById('fileinput').click(); return false;">Browse Files</a></p>
                    <input type="file" id="fileinput" name="excel_file" accept=".xlsx, .xls" style="display: none;" onchange="handleFileSelect(event);">
                </div>
                <div class="upload-attendance">
                    <button type="submit" class="upload btn">Upload</button>
                </div>
            </div>
        </form>
    </section>
@endsection
@section('script')
<script type="text/javascript" src="{{ asset('js/employee-table.js') }}"></script>
<script type="text/javascript">
    window.baseUrls = {
        getTable: '{{ route('employee-dashboard') }}',
    }
</script>
<script>
    function dragOverHandler(event) {
        event.preventDefault();
        document.getElementById('drop-area').classList.add('dragover');
    }

    function dropHandler(event) {
        event.preventDefault();
        document.getElementById('drop-area').classList.remove('dragover');

        var files = event.dataTransfer.files;
        if (files && files.length > 0) {
            var fileInput = document.getElementById('fileinput');
            fileInput.files = files;

            handleFileSelect(event);
        }
    }

    function handleFileSelect(event) {
        var files = event.target.files || event.dataTransfer.files; // Use event.target.files or event.dataTransfer.files depending on where the event comes from
        var uploadedFileName = document.getElementById('uploadedFileName');

        if (files && files.length > 0) {
            var fileName = files[0].name;
            uploadedFileName.textContent = fileName;
            document.getElementById('show_file').style.display = 'block';
        } else {
            uploadedFileName.textContent = '';
            document.getElementById('show_file').style.display = 'none';
        }
    }
</script>
@endsection
