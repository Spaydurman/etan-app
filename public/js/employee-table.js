$(function () {
    $('#employee-table').DataTable().destroy();
    var table = $('#employee-table').DataTable({
        processing: true,
        serverSide: true,
        autoWidth: false,
        scrollX: '100%',
        ajax: window.baseUrls.getTable,
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


document.addEventListener("DOMContentLoaded", function() {
    const importButton = document.getElementById('importButton');
    const importPopup = document.querySelector('.import-attendance');
    const closePopup = document.querySelector('.close-import-attendance');
    // Toggle visibility of import popup
    importButton.addEventListener('click', function() {
        importPopup.style.display = importPopup.style.display === 'none' ? 'flex' : 'none';
    });

    closePopup.addEventListener('click', function() {
        importPopup.style.display = 'none';  // Ensure it hides the popup
        resetFileInput();  // Clear the file input and reset the display
    });

    function resetFileInput() {
        const fileInput = document.getElementById('fileinput');
        fileInput.value = '';

        const uploadedFileName = document.getElementById('uploadedFileName');
        uploadedFileName.textContent = '';
    }

});



document.getElementById('attendance-upload-form').addEventListener('submit', function(event) {
    event.preventDefault();

    let form = document.getElementById('attendance-upload-form');
    let formData = new FormData(form);
    Swal.fire({
        html: '<svg xmlns="http://www.w3.org/2000/svg" width="3em" height="3em" viewBox="0 0 24 24"><circle cx="12" cy="2" r="0" fill="#1B263B"><animate attributeName="r" begin="0" calcMode="spline" dur="1s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle><circle cx="12" cy="2" r="0" fill="#415A77" transform="rotate(45 12 12)"><animate attributeName="r" begin="0.125s" calcMode="spline" dur="1s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle><circle cx="12" cy="2" r="0" fill="currentColor" transform="rotate(90 12 12)"><animate attributeName="r" begin="0.25s" calcMode="spline" dur="1s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle><circle cx="12" cy="2" r="0" fill="currentColor" transform="rotate(135 12 12)"><animate attributeName="r" begin="0.375s" calcMode="spline" dur="1s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle><circle cx="12" cy="2" r="0" fill="currentColor" transform="rotate(180 12 12)"><animate attributeName="r" begin="0.5s" calcMode="spline" dur="1s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle><circle cx="12" cy="2" r="0" fill="currentColor" transform="rotate(225 12 12)"><animate attributeName="r" begin="0.625s" calcMode="spline" dur="1s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle><circle cx="12" cy="2" r="0" fill="currentColor" transform="rotate(270 12 12)"><animate attributeName="r" begin="0.75s" calcMode="spline" dur="1s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle><circle cx="12" cy="2" r="0" fill="currentColor" transform="rotate(315 12 12)"><animate attributeName="r" begin="0.875s" calcMode="spline" dur="1s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle></svg><br>Please wait while we process your request.',
        allowOutsideClick: false,
        showCancelButton: false,
        showConfirmButton: false,
        buttons: false,
        onBeforeOpen: () => {
          Swal.showLoading();
        }
      });
    axios.post(form.action, formData)
        .then(function(response) {
            Swal.close();
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
            Swal.close();
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
