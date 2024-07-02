document.getElementById('add-account-form').addEventListener('submit', function(event) {
    event.preventDefault();

    let form = document.getElementById('add-account-form');
    let formData = new FormData(form);
    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to create an account?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            axios.post(form.action, formData)
            .then(function(response) {
                if(response.data.status === 'success'){
                    Swal.fire({
                        title: 'Success!',
                        text: response.data.message,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
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
        }
    });

});
