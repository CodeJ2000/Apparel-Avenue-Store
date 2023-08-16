$(document).ready(function () {
    $("#productTable").on("click", ".edit-button", function () {
        $("#staticBackdrop").modal("show");
        console.log("edit form");
        $("#staticBackdropLabel").html("Edit product");
        $("#btn-submit").html("Update Product");
        $("#formMode").val("edit");
        $(".images").removeAttr("required");
        productId = $(this).data("id");
        console.log(productId);
        // Make an AJAX request to get the product data
        $.ajax({
            url: editUrl.replace(":id", productId),
            method: "GET",
            dataType: "json",
            success: function (response) {
                $("#name").val(response.name);
                $("#description").val(response.description);
                $("#price").val(response.price);
                $("#categorySelect").val(response.category_id);
            },
            error: function (xhr) {
                console.log("error edit");
            },
        });
    });
});
