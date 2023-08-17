$(document).ready(function () {
    $("#editProductForm").submit(function (e) {
        e.preventDefault();
        let fd = new FormData(this);
        console.log("submitted");
        $.ajax({
            url: updateUrl.replace(":id", productId),
            method: "POST",
            data: fd,
            cache: false,
            processData: false,
            contentType: false,
            success: function (response) {
                $("#edit-product-form").modal("hide");
                Swal.fire({
                    title: "Successful!",
                    text: "Successfully Updated",
                    icon: "success",
                    showCancelButton: false,
                    showConfirmButton: false,
                    timer: 2000, // Set a timer to automatically close the Swal after 2 seconds
                });
                $(".error-msg").html("");

                $("#editProductForm")[0].reset();
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

    $("#productTable").on("click", ".edit-button", function () {
        productId = $(this).data("id");
        console.log(productId);
        // Make an AJAX request to get the product data
        $.ajax({
            url: editUrl.replace(":id", productId),
            method: "GET",
            dataType: "json",
            data: {
                id: productId,
                _token: csrf_token,
            },
            success: function (response) {
                $("#edit-product-form").modal("show");
                $("#name").val(response.name);
                $("#description").val(response.description);
                $("#price").val(response.price);
                $(".categorySelect").val(response.category_id);

                console.log("success edit");

                console.log(response);
            },
            error: function () {
                console.log("error edit");
            },
        });
    });
});
