$(document).ready(function () {
    $("#openAddProductForm").click(function () {
        $("#addProductForm")[0].reset();
    });

    $("#addProductForm").submit(function (e) {
        e.preventDefault();
        $(".error-msg").html("");
        let formData = new FormData(this);
        $.ajax({
            url: addUrl,
            method: "POST",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                $("#add-product-form").modal("hide");
                Swal.fire({
                    title: "Successful!",
                    text: "Successfully Added",
                    icon: "success",
                    showCancelButton: false,
                    showConfirmButton: false,
                    timer: 2000, // Set a timer to automatically close the Swal after 2 seconds
                });
                $(".error-msg").html("");
                $("#addProductForm")[0].reset();
            },
            error: function (xhr) {
                $(".error-msg").html("");
                // console.log(xhr.responseJSON.errors);
                let errors = xhr.responseJSON.errors;
                // console.log(errors);
                $.each(errors, function (field, error) {
                    $("." + field + "-error").html(error);
                });
            },
        });
    });
});
