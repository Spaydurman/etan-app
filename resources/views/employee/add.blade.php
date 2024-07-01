@section('css')
    <link rel="stylesheet" href="{{ asset('css/employee.css') }}">
@endsection
@extends('layout')

@section('contents')
    <div class="info-container">
        <form id="new-employee-form" action="{{ route('employee.create') }}" method="POST"class="new-employee" enctype="multipart/form-data">
            @csrf
            <section class="upload-personal-info">
                <div class="upload-con">
                    <div class="upload">
                        <svg id="default-svg" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M12 11.385q-1.237 0-2.119-.882T9 8.385t.881-2.12T12 5.386t2.119.88t.881 2.12t-.881 2.118t-2.119.882m-7 7.23V16.97q0-.619.36-1.158q.361-.54.97-.838q1.416-.679 2.834-1.018q1.417-.34 2.836-.34t2.837.34t2.832 1.018q.61.298.97.838q.361.539.361 1.158v1.646zm1-1h12v-.646q0-.332-.215-.625q-.214-.292-.593-.494q-1.234-.598-2.546-.916T12 14.616t-2.646.318t-2.546.916q-.38.202-.593.494Q6 16.637 6 16.97zm6-7.23q.825 0 1.413-.588T14 8.384t-.587-1.412T12 6.384t-1.412.588T10 8.384t.588 1.413t1.412.587m0 7.232"/></svg>
                        <img src="" alt="" id="preview" >
                        <input type="file" name="image" id="image" accept="image/*">
                        <label for="image">+</label>
                    </div>
                </div>
                <div class="personal-info">
                    <h1>Personal Information</h1>
                    <div class="name input-flex2">
                        <div class="input">
                            <label for="firstname">First Name</label>
                            <input type="text" name="first_name" id="firstname" class="firstname" required>
                        </div>
                        <div class="input">
                            <label for="lastname">Last Name</label>
                            <input type="text" name="last_name" id="lastname" class="lastname" required>
                        </div>
                        <div class="input">
                            <label for="middlename">Middle Name</label>
                            <input type="text" name="middle_name" id="middlename" class="middlename" required>
                        </div>
                    </div>
                    <div class="other-personal-info input-flex2">
                        <div class="input">
                            <label for="birth">Date of Birth</label>
                            <input type="date" name="birth" id="birth" class="birth" required>
                        </div>
                        <div class="input">
                            <label for="nationality">Nationality</label>
                            <input type="text" name="nationality" id="nationality" class="nationality"required>
                        </div>
                        <div class="input">
                            <label for="gender">Gender</label>
                            <input type="text" name="gender" id="gender" class="gender" required>
                        </div>
                    </div>
                </div>
            </section>
            <section class="job-contact">
                <div class="job-description">
                    <h1>Job Description</h1>
                    <div class="job input-flex2">
                        <div class="input">
                            <label for="position">Position/Designation</label>
                            <input type="text" name="position" id="position" class="position" required>
                        </div>
                        <div class="input">
                            <label for="job-type">Job Type</label>
                            <input type="text" name="job_type" id="job-type" class="job-type" required>
                        </div>
                    </div>
                    <div class="date input-flex2">
                        <div class="input">
                            <label for="date-hired">Date Hired</label>
                            <input type="date" name="date-hired" id="date-hired" class="date-hired" required>
                        </div>
                        <div class="input">
                            <label for="start-date">Start Date</label>
                            <input type="date" name="start-date" id="start-date" class="start-date" required>
                        </div>
                    </div>
                    <div class="input">
                        <label for="supervisor">Supervisor</label>
                        <input type="text" name="supervisor" id="supervisor" class="supervisor" required>
                    </div>
                    <div class="rate-id input-flex2">
                        <div class="input">
                            <label for="daily-rate">Daily Rate (₱)</label>
                            <input type="number" name="daily-rate" id="daily-rate" class="daily-rate" required>
                        </div>
                        <div class="input">
                            <label for="employee-id">Emplyoee ID</label>
                            <input type="number" name="employee_id" id="employee-id" class="employee-id" required>
                        </div>
                    </div>

                    <h1>Total Cash Advance Balance (₱)</h1>
                    <div class="input">
                        <input type="number" name="cab" id="cab" class="cab" disabled>
                    </div>
                </div>
                <div class="contact-information">
                    <h1>Contact Information</h1>
                    <div class="number-email input-flex2">
                        <div class="input">
                            <label for="contact-number">Contact Number</label>
                            <input type="number" name="contact_number" id="contact-number" class="contact-number" required>
                        </div>
                        <div class="input">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="email" required>
                        </div>
                    </div>
                    <div class="input">
                        <label for="address">Address</label>
                        <input type="text" name="address" id="address" class="address" required>
                    </div>
                    <div class="file-upload">
                        <h1>File Upload</h1>
                        <div id="drop-area" class="drop-area" ondrop="dropHandler(event);" ondragover="dragOverHandler(event);" >
                            <div id="show_img" style="display: none;">
                                <img id="uploadedImage" src="#" alt="Uploaded Image" style="max-width: 100%; max-height: 200px;">
                            </div>
                            <div id="show_pdf" style="display: none;">
                                <embed id="uploadedPdf" src="#" type="application/pdf" width="100%" height="200px" />
                            </div>
                            <div id="show_file" style="display: none;">
                                <p id="uploadedFileName"></p>
                            </div>
                            <svg id="uploadIcon" class="upload-icon" xmlns="http://www.w3.org/2000/svg" width="1.15em" height="1em" viewBox="0 0 16 14"><path fill="currentColor" d="M12 11c-.28 0-.5-.22-.5-.5s.22-.5.5-.5c1.65 0 3-1.35 3-3s-1.35-3-3-3h-1.05c-.18 0-.34-.09-.43-.25C9.88 2.65 8.76 2 7.51 2c-1.93 0-3.5 1.57-3.5 3.5c0 .28-.22.5-.5.5h-.5c-1.1 0-2 .9-2 2s.9 2 2 2c.28 0 .5.22.5.5s-.22.5-.5.5c-1.65 0-3-1.35-3-3s1.35-3 3-3h.03c.25-2.25 2.16-4 4.47-4c1.49 0 2.89.76 3.72 2h.78c2.21 0 4 1.79 4 4s-1.79 4-4 4Z"/><path fill="currentColor" d="M10 9.25a.47.47 0 0 1-.35-.15L7.5 6.95L5.35 9.1c-.2.2-.51.2-.71 0s-.2-.51 0-.71l2.5-2.5c.2-.2.51-.2.71 0l2.5 2.5c.2.2.2.51 0 .71c-.1.1-.23.15-.35.15"/><path fill="currentColor" d="M7.5 13c-.28 0-.5-.22-.5-.5v-6c0-.28.22-.5.5-.5s.5.22.5.5v6c0 .28-.22.5-.5.5"/></svg>
                            <p class="upload-text">Drag and drop files here <br> or <br> <a id="browseButton" class="browse" onclick="document.getElementById('fileinput').click(); return false;">Browse Files</a></p>
                            <input type="file" id="fileinput" name="file_upload" class="" style="display: none;" />
                        </div>
                        <span class="text-danger">@error('image') {{ $message }} @enderror</span>
                    </div>
                </div>

            </section>
            <div class="save-con">
                <button type="button" id="importButton" class="save btn" style="margin-right: 1rem">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M8.71 7.71L11 5.41V15a1 1 0 0 0 2 0V5.41l2.29 2.3a1 1 0 0 0 1.42 0a1 1 0 0 0 0-1.42l-4-4a1 1 0 0 0-.33-.21a1 1 0 0 0-.76 0a1 1 0 0 0-.33.21l-4 4a1 1 0 1 0 1.42 1.42M21 14a1 1 0 0 0-1 1v4a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-4a1 1 0 0 0-2 0v4a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3v-4a1 1 0 0 0-1-1"/></svg>
                    Import
                </button>
                <button type="submit" class="save">Save</button>
            </div>
        </form>
    </div>

    <section class="import-attendance">
        <form action="{{ route('employee.upload') }}" id="employee-upload-form" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="file-import">
                <h1>Add Employee Import</h1>
                <button type="button" class="close-import-attendance"> x </button>
                <div id="drop-area-import" class="drop-area" ondrop="dropHandlerImport(event);" ondragover="dragOverHandlerImport(event);">
                    <div id="show_file_import" style="display: none;">
                        <p id="uploadedFileNameImport"></p>
                    </div>
                    <svg id="uploadIcon" class="upload-icon" xmlns="http://www.w3.org/2000/svg" width="1.15em" height="1em" viewBox="0 0 16 14"><path fill="currentColor" d="M12 11c-.28 0-.5-.22-.5-.5s.22-.5.5-.5c1.65 0 3-1.35 3-3s-1.35-3-3-3h-1.05c-.18 0-.34-.09-.43-.25C9.88 2.65 8.76 2 7.51 2c-1.93 0-3.5 1.57-3.5 3.5c0 .28-.22.5-.5.5h-.5c-1.1 0-2 .9-2 2s.9 2 2 2c.28 0 .5.22.5.5s-.22.5-.5.5c-1.65 0-3-1.35-3-3s1.35-3 3-3h.03c.25-2.25 2.16-4 4.47-4c1.49 0 2.89.76 3.72 2h.78c2.21 0 4 1.79 4 4s-1.79 4-4 4Z"/><path fill="currentColor" d="M10 9.25a.47.47 0 0 1-.35-.15L7.5 6.95L5.35 9.1c-.2.2-.51.2-.71 0s-.2-.51 0-.71l2.5-2.5c.2-.2.51-.2.71 0l2.5 2.5c.2.2.2.51 0 .71c-.1.1-.23.15-.35.15"/><path fill="currentColor" d="M7.5 13c-.28 0-.5-.22-.5-.5v-6c0-.28.22-.5.5-.5s.5.22.5.5v6c0 .28-.22.5-.5.5"/></svg>
                    <p class="upload-text">Drag and drop Excel files here <br> or <br> <a id="browseButton" class="browse" onclick="document.getElementById('fileimport').click(); return false;">Browse Files</a></p>
                    <input type="file" id="fileimport" name="excel_file" accept=".xlsx, .xls" style="display: none;" onchange="handleFileImport(event);">
                </div>
                <div class="upload-employee">
                    <button type="submit" class="upload-btn">Upload</button>
                </div>
            </div>
        </form>
    </section>
@endsection
@section('script')
    <script>
        window.baseUrls = {
            getTable: '{{ route('employee-dashboard') }}',
        }
        function dragOverHandlerImport(event) {
            event.preventDefault();
            document.getElementById('drop-area-import').classList.add('dragover');
        }

        function dropHandlerImport(event) {
            event.preventDefault();
            document.getElementById('drop-area-import').classList.remove('dragover');

            var files = event.dataTransfer.files;
            if (files && files.length > 0) {
                var fileInput = document.getElementById('fileimport');
                fileInput.files = files;

                handleFileImport(event);
            }
        }

        function handleFileImport(event) {
            var files = event.target.files || event.dataTransfer.files;
            var uploadedFileName = document.getElementById('uploadedFileNameImport');
            console.log(uploadedFileName);
            if (files && files.length > 0) {
                var fileName = files[0].name;
                uploadedFileName.textContent = fileName;
                document.getElementById('show_file_import').style.display = 'block';
            } else {
                uploadedFileName.textContent = '';
                document.getElementById('show_file_import').style.display = 'none';
            }
        }
    </script>
    <script>
       document.getElementById('image').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.getElementById('preview');
                    const svg = document.getElementById('default-svg');
                    img.src = e.target.result;
                    img.style.display = 'block';
                    svg.style.display = 'none';
                }
                reader.readAsDataURL(file);
            }
        });
        document.addEventListener('DOMContentLoaded', function() {
            const img = document.getElementById('preview');
            const svg = document.getElementById('default-svg');
            if (img.src) {
                img.style.display = 'none';
                svg.style.display = 'block';
            }
        });
    </script>
    <script>
        document.getElementById('fileinput').addEventListener('change', handleFileSelect);

        function handleFileSelect(event) {
            const file = event.target.files[0];
            const fileType = file.type;
            const reader = new FileReader();

            reader.onload = function (e) {
                if (fileType.startsWith('image/')) {
                    const image = document.getElementById('uploadedImage');
                    image.src = e.target.result;
                    document.getElementById('show_img').style.display = 'block';
                    document.getElementById('show_pdf').style.display = 'none';
                    document.getElementById('show_file').style.display = 'none';
                } else if (fileType === 'application/pdf') {
                    const pdf = document.getElementById('uploadedPdf');
                    pdf.src = e.target.result;
                    document.getElementById('show_img').style.display = 'none';
                    document.getElementById('show_pdf').style.display = 'block';
                    document.getElementById('show_file').style.display = 'none';
                } else {
                    const fileName = document.getElementById('uploadedFileName');
                    fileName.textContent = file.name;
                    document.getElementById('show_img').style.display = 'none';
                    document.getElementById('show_pdf').style.display = 'none';
                    document.getElementById('show_file').style.display = 'block';
                }
                document.getElementById('uploadIcon').style.display = 'none';
            };

            reader.readAsDataURL(file);
            document.getElementById('fileNameInput').value = file.name;
        }

        document.getElementById('drop-area').addEventListener('dragover', dragOverHandler);
        document.getElementById('drop-area').addEventListener('drop', dropHandler);

        function dragOverHandler(event) {
            event.preventDefault();
            document.getElementById('drop-area').classList.add('drag-over');
        }

        function dropHandler(event) {
            event.preventDefault();
            const file = event.dataTransfer.files[0];
            const fileType = file.type;
            const reader = new FileReader();

            reader.onload = function (e) {
                if (fileType.startsWith('image/')) {
                    const image = document.getElementById('uploadedImage');
                    image.src = e.target.result;
                    document.getElementById('show_img').style.display = 'block';
                    document.getElementById('show_pdf').style.display = 'none';
                    document.getElementById('show_file').style.display = 'none';
                } else if (fileType === 'application/pdf') {
                    const pdf = document.getElementById('uploadedPdf');
                    pdf.src = e.target.result;
                    document.getElementById('show_img').style.display = 'none';
                    document.getElementById('show_pdf').style.display = 'block';
                    document.getElementById('show_file').style.display = 'none';
                } else {
                    const fileName = document.getElementById('uploadedFileName');
                    fileName.textContent = file.name;
                    document.getElementById('show_img').style.display = 'none';
                    document.getElementById('show_pdf').style.display = 'none';
                    document.getElementById('show_file').style.display = 'block';
                }
                document.getElementById('uploadIcon').style.display = 'none';
            };

            reader.readAsDataURL(file);
            document.getElementById('fileNameInput').value = file.name;
            document.getElementById('fileinput').files = event.dataTransfer.files;
            handleFileSelect({ target: { files: [file] } });
        }
    </script>


    <script type="text/javascript" src="{{ asset('js/add.js') }}"></script>
@endsection
