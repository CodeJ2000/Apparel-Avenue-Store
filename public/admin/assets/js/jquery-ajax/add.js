$(document).ready(function () {
    $("#openAddProductForm").click(function () {
        $("#addProductForm")[0].reset();
        $("#staticBackdropLabel").html("Add new product");
        $("#btn-submit").html("Add Product");
        $("#formMode").val("add");
        $(".images").attr("required", "required");
    });
});
