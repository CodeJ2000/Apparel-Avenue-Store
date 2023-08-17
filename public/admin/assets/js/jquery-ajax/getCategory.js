$(document).ready(function () {
    $.ajax({
        //Route url of the data from the server
        url: getCategoryRoute,
        method: "GET", //GET for getting the data
        dataType: "json", // data type must be in json format
        success: function (data) {
            const categorySelect = $(".categorySelect"); //get the select tag
            let categoryData = data.data; //get the data

            //loop the data and append in the select tag
            $.each(categoryData, function (index, category) {
                categorySelect.append(
                    $("<option>", {
                        value: category.id,
                        text: category.name,
                    })
                );
            });
        },
        error: function () {
            console.log("failed");
        },
    });
});
