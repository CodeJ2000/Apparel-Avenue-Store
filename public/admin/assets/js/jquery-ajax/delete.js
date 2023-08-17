$(document).ready(function () {
    $("#productTable").on("click", ".delete-button", function (e) {
        e.preventDefault();
        let id = $(this).data("id");
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
                $.ajax({
                    url: deleteUrl.replace(":id", id),
                    method: "POST",
                    cache: false,
                    proccessData: false,
                    contentType: false,
                    success: function () {
                        console.log("deleted successfully.");
                        Swal.fire(
                            "Deleted!",
                            "Your file has been deleted.",
                            "success"
                        );
                        $("#productTable").DataTable().ajax.reload();
                    },
                    error: function (xhr) {
                        console.log("error delete");
                    },
                });
            }
        });
    });
});
