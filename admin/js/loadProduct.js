/**
 * Noah Tomkins, 000790079
 * 
 * Noah Computers Webstore
 * 
 * Created: 27/10/2020
 * I, Noah Tomkins, 000790079 certify that this material is my original work.  
 * No other person"s work has been used without due acknowledgement.
 */

$(document).ready(function() {

    let product_id = document.getElementById("product_id");

    // get a product by the id
    let product_url = "../php/products/getProductById.php?id=" + product_id.innerHTML;
    fetch(product_url, { credentials: 'include' })
        .then(response => response.json())
        .then(displayProduct);

    /**
     * Takes in a json object of a product
     * and fills the edit form with the current
     * products items
     * 
     * @param {JSON} json 
     */
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