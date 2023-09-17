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

//Format date and time
function date_format(dateString) {
    const date = new Date(dateString);
    const day = date.getDate();
    const month = date.toLocaleString("default", {
        month: "long",
    });
    const year = date.getFullYear();
    const formatDate = `${month} ${day}, ${year}`;
    return formatDate;
}

// Reusable function fo\    r adding data
// (Name of the button for modal, id of modal, name of form, url route,btn id for adding , button placeholder, table)
function add(modalBtn = "", modal = "", form, addUrl, btnId, btn, table = "") {
    //Attach a click event to the button that opens the modal
    if (modalBtn !== "") {
        $(modalBtn).click(function () {
            $(form)[0].reset(); //reset the form inputs
            $(btnId).html(btn); //set button text
        });
    }

    //submit form when it's submitted
    $(form).submit(function (e) {
        e.preventDefault(); //prevent default form submission
        $(btnId).html("Adding...").prop("disabled", true); //change button text
        if (modalBtn !== "") {
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
                $(btnId).html(btn).prop("disabled", false); //Restore button text
                if (modalBtn !== "") {
                    $(modal).modal("hide"); //hide the modal
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
                if (modalBtn !== "") {
                    $(".error-msg").html(""); //clear error messages
                }
                if (table !== "") {
                    $(table).DataTable().ajax.reload(); //Reload datatable
                }
                if (
                    btn == "Update to Cart" ||
                    btnId == "#add-shipping-address-btn"
                ) {
                    window.location.reload();
                }
            },
            error: function (xhr) {
                if (modalBtn !== "" || btnId == "#add-shipping-address-btn") {
                    $(".error-msg").html(""); //clear error messages
                    $(btnId).html(btn).prop("disabled", false); //restore button text
                    //handle validation errors
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function (field, error) {
                        $("." + field + "-error").html(error);
                    });
                }
            },
        }).fail(function (xhr) {
            let errors = xhr.status; //Get the error status
            $(btnId).html(btn);

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
function edit(form, updateUrl, editUrl, table, btn, csrf_token, modal) {
    //initialize variable id
    let id;
    //click event for edit form
    $(table).on("click", ".edit-button", function () {
        id = $(this).data("id"); // Populate the variable id with id value
        $(modal).modal("show"); //show the edit modal form
        console.log(id);
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
                $("#size_input").val(response.name);

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
                $(modal).modal("hide"); // Hide the modal
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
                        Swal.fire({
                            title: "Successful!",
                            text: response.message,
                            icon: "success",
                            showCancelButton: false,
                            showConfirmButton: false,
                            timer: 2000, // Set a timer to automatically close the Swal after 2 seconds
                        });
                        if (table == "#cart-table") {
                            window.location.reload();
                        }
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

function status(data) {
    if (data === "Pending") {
        return (
            '<span class="bg-warning text-white p-2 rounded">' +
            data +
            "</span>"
        );
    } else if (data === "On Delivery") {
        return (
            '<span class="bg-info text-white p-2 rounded">' + data + "</span>"
        );
    } else if (data === "Cancelled") {
        return (
            '<span class="bg-danger text-white p-2 rounded">' + data + "</span>"
        );
    } else if (data === "Delivered") {
        return (
            '<span class="bg-success text-white p-2 rounded">' +
            data +
            "</span>"
        );
    } else {
        return data; // Return data as is if no styling is needed
    }
}

function editAndDeleteBtn(data) {
    return `
              <button id="edit-btn" class="btn btn-primary btn-sm edit-button px-2 py-1" data-id="${data.id}"><i class="fa-regular fa-pen-to-square fs-6" style="color: #ffffff;"></i></button>
              <button class="btn btn-danger btn-sm delete-button px-2 py-1" data-id="${data.id}"><i class="fa-solid fa-trash-can fs-6" style="color: #ffffff;"></i></button>
          `;
}
