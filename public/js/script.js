// Common delete method for all actions !!
$(document).on('click', '.confirmDelete', function() {
    const record = $(this).attr("record");
    const id = $(this).data("id");
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
            axios.get('/delete-'+record+'/'+id).then((response) => {
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
                    else if(record == 'Purchase') {
                        getPurchase();
                    }
                    else if(record == 'Invoice') {
                        getInvoices();
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

// Common status update method for all action !!
$(document).on('click', '.updateStatus', function() {
    const record = $(this).attr("record");
    const id = $(this).data("id");

    Swal.fire({
        title: 'Are you sure?',
        text: "You want to approve this "+record,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, approve it!'
    }).then((result) => {
        if (result.value) {
            axios.post('/update-'+record+'-status', {id: id}).then((response) => {
                if(response.status == 200) {
                    successMessage(record+' Approved Successfully !')

                    if(record == 'Purchase') {
                        getPurchase();
                    }

                } else {
                    errorMessage('Something Went Wrong !')
                }
            }).catch((error) => {
                errorMessage('Something Went Wrong !')
            })
        }
    });
});

// Config Toast
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});

// Common method for all success messages !!
function successMessage(message) {
    Toast.fire({
        icon: 'success',
        title: message
    })
}

// Common method for all error messages !!
function errorMessage(message) {
    Toast.fire({
        icon: 'error',
        title: message
    });
}

// Common method for all error messages !!
function warningMessage(message) {
    Toast.fire({
        icon: 'warning',
        title: message
    })
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
