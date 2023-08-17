$(document).ready(function () {
    const loadingRow = $("#loadingRow");
    $("#productTable").DataTable({
        serverSide: true,
        ajax: productJsonRoute,
        processData: false,
        contentType: false,
        columns: [
            { data: "name" },
            {
                data: "description",
                render: function (data, type, row) {
                    if (type === "display" && data.length > 50) {
                        return data.substr(0, 50) + "...";
                    }
                    return data || "";
                },
            },
            { data: "price" },
            { data: "category.name", name: "category.name", orderable: false },
            {
                data: "created_at",
                render: function (data, type, row) {
                    const date = new Date(data);
                    const day = date.getDate();
                    const month = date.toLocaleString("default", {
                        month: "long",
                    });
                    const year = date.getFullYear();
                    const formatDate = `${month} ${day}, ${year}`;
                    return formatDate;
                },
            },
            {
                data: null,
                orderable: false,
                searchable: false,
                width: "100px",
                render: function (data, type, row) {
                    return `
                    <button id="edit-btn" class="btn btn-primary btn-sm edit-button px-2 py-1" data-id="${data.id}"><i class="fa-regular fa-pen-to-square fs-6" style="color: #ffffff;"></i></button>
                    <button class="btn btn-danger btn-sm delete-button px-2 py-1" data-id="${data.id}"><i class="fa-solid fa-trash-can fs-6" style="color: #ffffff;"></i></button>
                `;
                },
            },
        ],
    });
});
