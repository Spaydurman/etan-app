document.addEventListener("DOMContentLoaded", function() {
    const importButton = document.getElementById('importButton');
    const importPopup = document.querySelector('.import-attendance');
    const closePopup = document.querySelector('.close-import-attendance');
    // Toggle visibility of import popup
    importButton.addEventListener('click', function() {
        importPopup.style.display = importPopup.style.display === 'flex' ? 'none' : 'flex';
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

document.getElementById('employee-upload-form').addEventListener('submit', function(event) {
    event.preventDefault();

    let form = document.getElementById('employee-upload-form');
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
                    window.location.href = window.baseUrls.getTable;
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
