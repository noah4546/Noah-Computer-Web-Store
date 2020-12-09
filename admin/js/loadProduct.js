$(document).ready(function() {

    let product_id = document.getElementById("product_id");

    let product_url = "../php/products/getProductById.php?id=" + product_id.innerHTML;
    fetch(product_url, { credentials: 'include' })
        .then(response => response.json())
        .then(displayProduct);

    function displayProduct(json) {

        console.log(json);

        if (json.success == "true") {
            document.getElementById("product_name").innerHTML = json.product.name;
        } else {
            document.getElementById("product_name").innerHTML = "Couldn't Find Product";
        }
    }

});