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
                        <input type="number" name="cab" id="cab" class="cab" required>
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
                        {{-- <label for="fileinput" class="control-label"><h1>File Upload</h1></label> --}}
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
                            {{-- <i id="uploadIcon" class="upload-icon"></i> --}}
                            <svg id="uploadIcon" class="upload-icon" xmlns="http://www.w3.org/2000/svg" width="1.15em" height="1em" viewBox="0 0 16 14"><path fill="currentColor" d="M12 11c-.28 0-.5-.22-.5-.5s.22-.5.5-.5c1.65 0 3-1.35 3-3s-1.35-3-3-3h-1.05c-.18 0-.34-.09-.43-.25C9.88 2.65 8.76 2 7.51 2c-1.93 0-3.5 1.57-3.5 3.5c0 .28-.22.5-.5.5h-.5c-1.1 0-2 .9-2 2s.9 2 2 2c.28 0 .5.22.5.5s-.22.5-.5.5c-1.65 0-3-1.35-3-3s1.35-3 3-3h.03c.25-2.25 2.16-4 4.47-4c1.49 0 2.89.76 3.72 2h.78c2.21 0 4 1.79 4 4s-1.79 4-4 4Z"/><path fill="currentColor" d="M10 9.25a.47.47 0 0 1-.35-.15L7.5 6.95L5.35 9.1c-.2.2-.51.2-.71 0s-.2-.51 0-.71l2.5-2.5c.2-.2.51-.2.71 0l2.5 2.5c.2.2.2.51 0 .71c-.1.1-.23.15-.35.15"/><path fill="currentColor" d="M7.5 13c-.28 0-.5-.22-.5-.5v-6c0-.28.22-.5.5-.5s.5.22.5.5v6c0 .28-.22.5-.5.5"/></svg>
                            <p class="upload-text">Drag and drop files here <br> or <br> <a id="browseButton" class="browse" onclick="document.getElementById('fileinput').click(); return false;">Browse Files</a></p>
                            {{-- <button  id="browseButton" class="browse" onclick="document.getElementById('fileinput').click(); return false;">Browse Files</button> --}}
                            <input type="file" id="fileinput" name="file_upload" class="" style="display: none;" />
                        </div>
                        <span class="text-danger">@error('image') {{ $message }} @enderror</span>
                    </div>
                </div>

            </section>
            <div class="save-con">
                <button type="submit" class="save">Save</button>
            </div>
        </form>
    </div>
@endsection
@section('script')
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
    <script>
        document.getElementById('new-employee-form').addEventListener('submit', function(event) {
            event.preventDefault();

            let form = document.getElementById('new-employee-form');
            let formData = new FormData(form);

            axios.post(form.action, formData)
                .then(function(response) {
                    if(response.data.status === 'success'){
                        Swal.fire({
                            title: 'Success!',
                            text: response.data.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            // Optional: You can reload the page or redirect to another page
                            window.location.reload();
                        });
                    }else if(response.data.status === 'error'){
                        Swal.fire({
                            title: 'Error!',
                            text: response.data.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        })
                    }

                })
                .catch(function(error) {
                    if (error.response) {
                        // Server responded with a status other than 200 range
                        let errors = error.response.data.errors;
                        let errorMessages = '';
                        for (let field in errors) {
                            if (errors.hasOwnProperty(field)) {
                                errorMessages += errors[field].join('<br>') + '<br>';
                            }
                        }
                        Swal.fire({
                            title: 'Error!',
                            html: errorMessages,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        // Something else happened while setting up the request
                        console.error('Error', error.message);
                        Swal.fire({
                            title: 'Error!',
                            text: 'An unexpected error occurred.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
        });
    </script>
@endsection
