// Common delete method for all action !!
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
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });

                    Toast.fire({
                        icon: 'success',
                        title: record+' Deleted Successfully !'
                    });

                    if(record == 'User') {
                        getUser();
                    } else if(record == 'other') {
                        getOther();
                    }
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: 'Something Went Wrong !'
                    });
                }
            }).catch((error) => {
                Toast.fire({
                    icon: 'error',
                    title: error.message
                });
            })
        }
    });
})