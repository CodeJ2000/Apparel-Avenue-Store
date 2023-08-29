//Reusable function for datatable(name of table, route name )
function initializedDataTable(tableId, ajaxUrl, columnsConfig) {
    $(tableId).DataTable({
        serverSide: true, //Enable server-side processing
        ajax: ajaxUrl, //URL to fetch data from server
        processData: false,
        contentType: false,
        columns: columnsConfig, //Configuration for table columns
    });
}

// Reusable function fo\    r adding data
// (Name of the button for modal, name of form, button placeholder)
function add(openModal = "", form, addUrl, btn, table = "", redirectTo = "") {
    //Attach a click event to the button that opens the modal
    if (openModal !== "") {
        $(openModal).click(function () {
            $(form)[0].reset(); //reset the form inputs
            $("#add-btn").html(btn); //set button text
        });
    }
    //submit form when it's submitted
    $(form).submit(function (e) {
        e.preventDefault(); //prevent default form submission
        $("#add-btn").html("Adding..."); //change button text
        if (openModal !== "") {
            $(".error-msg").html(""); // clear error message
        }
        let formData = new FormData(this); //create FormData object
        //send AJAX request to add data
        $.ajax({
            url: addUrl, //URL to send data to
            method: "POST", //HTTP method
            data: formData, //Data to send
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log("success");

                $("#add-btn").html(btn); //Restore button text
                if (openModal !== "") {
                    $("#add-form").modal("hide"); //hide the modal
                }
                //show success notification
                Swal.fire({
                    title: "Successful!",
                    text: response.message,
                    icon: "success",
                    showCancelButton: false,
                    showConfirmButton: false,
                    timer: 2000, // Set a timer to automatically close the Swal after 2 seconds
                });
                if (openModal !== "") {
                    $(".error-msg").html(""); //clear error messages
                }
                if (table !== "") {
                    $(table).DataTable().ajax.reload(); //Reload datatable
                }
            },
            error: function (xhr) {
                if (openModal !== "") {
                    $(".error-msg").html(""); //clear error messages
                    $("#add-btn").html(btn); //restore button text
                    console.log("error");
                    //handle validation errors
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function (field, error) {
                        $("." + field + "-error").html(error);
                    });
                }
            },
        }).fail(function (xhr) {
            let errors = xhr.status; //Get the error status
            $("#add-btn").html(btn);

            //If not authenticated pop up a message showing the the user is not authenticated
            if (errors === 401) {
                Swal.fire(
                    "Don't have an account?",
                    "Please login first to proceed",
                    "question"
                );
            }
        });
    });
}

// reusable function for updating the data
// (form name, route name for update, route name for edit, name of table, button placeholder, csrf token  )
function edit(form, updateUrl, editUrl, table, btn, csrf_token) {
    //initialize variable id
    let id;
    //click event for edit form
    $(table).on("click", ".edit-button", function () {
        id = $(this).data("id"); // Populate the variable id with id value
        $("#edit-form").modal("show"); //show the edit modal form

        // AJAX request to get the product data
        $.ajax({
            url: editUrl.replace(":id", id), //URL to get the data to edit from server
            method: "GET", //HTTP method
            dataType: "json", //data type must be in json
            data: {
                id: id,
                _token: csrf_token, // Include CSRF token for security
            },
            success: function (response) {
                let sizes = response.sizes;
                // Populate form fields with fetched data
                $.each(response, function (index, value) {
                    $("#" + index).val(value);
                    if (index != "") {
                        $("." + index).val(value);
                        if (index === "sizes") {
                            $.each(sizes, function (size, stock) {
                                $("." + size).val(stock);
                            });
                        }
                    }
                });
            },
            error: function () {
                console.log("error edit");
            },
        });
    });

    // Submit form when it's submitted
    $(form).submit(function (e) {
        e.preventDefault(); // Prevent default form submission
        $("#update-btn").html("Updating..."); // Change button text
        let fd = new FormData(this); // Create FormData object

        // Send AJAX request to update data
        $.ajax({
            url: updateUrl.replace(":id", id), // URL to send data to
            data: fd, // Data to send
            method: "POST", // HTTP method
            cache: false,
            processData: false,
            contentType: false,
            success: function (response) {
                $("#edit-form").modal("hide"); // Hide the modal
                $("#update-btn").html(btn); // Restore button text

                // Show success notification
                Swal.fire({
                    title: "Successful!",
                    text: response.message,
                    icon: "success",
                    showCancelButton: false,
                    showConfirmButton: false,
                    timer: 2000, // Set a timer to automatically close the Swal after 2 seconds
                });
                $(".error-msg").html(""); // Clear error messages

                // Reset form and reload DataTable
                $(form)[0].reset();
                $(table).DataTable().ajax.reload();
            },
            error: function (xhr) {
                $(".error-msg").html(""); // Clear error messages
                $("#update-btn").html(btn); // Restore button text

                // Handle validation errors
                let errors = xhr.responseJSON.errors;
                $.each(errors, function (field, error) {
                    $("." + field + "-error").html(error);
                });
            },
        });
    });
}

// reusable function for deleting data
// (table name, route name for delete)
function deleteData(table, deleteUrl) {
    // Attach a click event to the delete button within the table
    $(table).on("click", ".delete-button", function (e) {
        e.preventDefault(); // Prevent the default link behavior
        let id = $(this).data("id"); // Get the ID of the record to delete

        // Show a confirmation modal before proceeding with deletion
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
                // Send an AJAX request to delete the data
                $.ajax({
                    url: deleteUrl.replace(":id", id), // URL to delete data
                    method: "POST", // HTTP method
                    cache: false,
                    proccessData: false,
                    contentType: false,
                    success: function (response) {
                        // Show success message
                        Swal.fire(
                            "Deleted!",
                            "The " +
                                response.data +
                                " has successfuly deleted!",
                            "success"
                        );
                        $(table).DataTable().ajax.reload(); // Reload DataTable
                    },
                    error: function (xhr) {
                        console.log("error delete");
                    },
                });
            }
        });
    });
}
