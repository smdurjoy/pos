// Common delete method for all actions !!
$(document).on('click', '.confirmDelete', function() {
    const record = $(this).attr("record");
    const recordId = $(this).attr("recordId");
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.value) {
            axios.get('/delete-'+record+'/'+recordId).then((response) => {
                if(response.status == 200 && response.data == 1) {
                    successMessage(record+' Deleted Successfully !')

                    if(record == 'User') {
                        getUser();
                    } 
                    else if(record == 'Supplier') {
                        getSuppliers();
                    }
                    else if(record == 'Customer') {
                        getCustomers();
                    }
                    else if(record == 'Unit') {
                        getUnits();
                    }
                    else if(record == 'Category') {
                        getCategories();
                    }
                    else if(record == 'Product') {
                        getProducts();
                    }
                    
                } else {
                    errorMessage('Something Went Wrong !') 
                }
            }).catch((error) => {
                errorMessage(error.message) 
            })
        }
    });
});

// Common method for all success messages !!
function successMessage(message) {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });

    Toast.fire({
        icon: 'success',
        title: message
    })
}

// Common method for all error messages !!
function errorMessage(message) {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });

    Toast.fire({
        icon: 'error',
        title: message
    });
}

// Update profile validation
function validation(formId, rules, messages) {
    $(formId).validate({
        rules: rules,
        messages: messages,
        
        errorElement: 'span',
        errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
        }
    });
}