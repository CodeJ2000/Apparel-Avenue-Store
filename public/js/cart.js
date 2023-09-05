function populateSizeOption(url, cartItem) {
    $.get(url, function (sizes) {
        sizes.forEach(function (size) {
            //store the option tag with size value and text
            let option = $("<option>", {
                value: size.id,
                text: size.name,
            });
            $("#size").append(option); //append the option into the select tag

            //if size id  match with the selected size id, auto select the option
            if (size.id === cartItem.size.id) {
                option.attr("selected", "selected");
            }
        }); //end of size loop

        //loop product size and pass the stocks value in the stocks html tag
        cartItem.product.sizes.forEach(function (size) {
            if (size.id === cartItem.size.id) {
                $("#stocks").text(size.pivot.stocks);
                $("#quantity")
                    .attr("max", size.pivot.stocks)
                    .val(cartItem.quantity);
            }
        }); //end product sze loop

        // size option on change
        $("#size").on("change", function () {
            let selectedSize = $(this).val();

            //loop product size and check if empty stocks then pass the stocks value to stocks html tag, disabled the add to cart button
            cartItem.product.sizes.forEach(function (size) {
                if (selectedSize == size.id) {
                    let stocksPerSize = size.pivot.stocks;
                    $("#stocks").text(size.pivot.stocks);
                    $("#quantity").attr("max", size.pivot.stocks);
                    if (stocksPerSize == "" || stocksPerSize == 0) {
                        $("#add-btn")
                            .text("Out of stocks")
                            .prop("disabled", true);
                        $("#add-btn").addClass("bg-secondary");
                    } else {
                        $("#add-btn")
                            .text("Update Cart")
                            .prop("disabled", false);
                        $("#add-btn").removeClass("bg-secondary");
                    }
                }
            }); //end product size loop
        }); //end size option on change
    });
}

//Update cart item
function updateCartItem(cartItemShowUrl, addUrl, sizeUrl) {
    $.get(
        cartItemShowUrl.replace(":cartItem", cartItemId),
        function (cartItem) {
            let product = cartItem.product; //store the product data from cartitem
            let images = cartItem.product.images; //store images from cartitem product
            let category = cartItem.product.category.name; //store the category name of the product

            //dynamically put the cartitem data in the respected tags
            $("#product-id").val(product.id);
            $("#product-name").text(product.name);
            $("#category-name").text(category);
            $("#MainImg").attr("src", "../" + images[0].image_url);

            //loop the small image tags add images file in to the src
            $(".small-img").each(function (index) {
                $(this).attr("src", "../" + images[index].image_url);
            });
            const productModal = document.getElementById("edit-product-modal"); //Reference to the product modal

            //add event listener for closing the product modal
            productModal.addEventListener("hidden.bs.modal", function () {
                //Empty the tags and image
                $("#product-id").val("");
                $("#product-name").text("");
                $("#category-name").text("");
                $("#MainImg").attr("src", "");

                //loop the small image tags add images file in to the src
                $(".small-img").each(function (index) {
                    $(this).attr("src", "");
                });
            });

            //get the size data and stocks
            populateSizeOption(sizeUrl, cartItem);

            //add or update product in the cart
            add("", "#updateToCartForm", addUrl, "Update to Cart", "");
        }
    );
}
