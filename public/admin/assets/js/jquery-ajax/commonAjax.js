function performAjax(url, method, formData) {
    $.ajax({
        url: url,
        method: method,
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            $("#staticBackdrop").modal("hide");
            swal("Successful", response.message, "success", {
                button: false,
            });
            setTimeout(() => {
                swal.close();
            }, 2000);
            $(".error-msg").html("");
            $("#addProductForm")[0].reset();
        },
        error: function (xhr) {
            $(".error-msg").html("");
            // console.log(xhr.responseJSON.errors);
            let errors = xhr.responseJSON.errors;
            // console.log(errors);
            $.each(errors, function (field, error) {
                $("#" + field + "-error").html(error);
            });
        },
    });
}
