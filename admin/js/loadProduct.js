$(document).ready(function() {

    let product_id = document.getElementById("product_id");

    let product_url = "../php/products/getProductById.php?id=" + product_id.innerHTML;
    fetch(product_url, { credentials: 'include' })
        .then(response => response.json())
        .then(displayProduct);

    function displayProduct(json) {

        console.log(json);

        if (json.success == "true") {

            $("#product_name").html(json.product.name);
            $("#name").val(json.product.name);
            $("#status").val(json.product.status);
            $("#status").change();
            $("#short_description").val(json.product.short_description);
            $("#long_description").val(json.product.long_description);
            $("#image_preview").attr("src", `../images/products/${json.product.image}`);
            $("#price").val(json.product.price);
            $("#discount").val(json.product.discount);
            $("#quantity").val(json.product.quantity);
        
        } else {
            $("#product_name").html("Couldn't Find Product");
        }
    }

});