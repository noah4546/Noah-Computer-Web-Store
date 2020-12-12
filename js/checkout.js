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

    let currentStep = 1;
    let hasAddress = 0;
    let currentAddress = "";

    let user_url = "php/getUserInfo.php";
    fetch(user_url, {credentials: 'include'})
        .then(response => response.json())
        .then(updateAddress);

    let cart_url = "php/cart/getCart.php";
    fetch(cart_url, {credentials: 'include'})
        .then(response => response.json())
        .then(updateCart);

    // if you click the step1 header it will bring you to step 1
    $("#step1 h2").click(function() {
        $(".step-info").hide();
        $("#step1 .step-info").show();
        currentStep = 1;
    });

    // if you click the step2 header it will bring you to step 2
    $("#step2 h2").click(function() {
        if (currentStep >= 2) {
            $(".step-info").hide();
            $("#step2 .step-info").show();
        }
        currentStep = 2;
    });

    // if you click the step3 header it will bring you to step 3
    $("#step3 h2").click(function() {
        if (currentStep >= 3) {
            $(".step-info").hide();
            $("#step3 .step-info").show();
        }
    });

    // hide the address form when the user chooses to use existing address
    $("#existing").click(function() {
        $(".address-form").hide();
    });

    // show the address form when the user chooses to use a new address
    $("#new").click(function() {
        $(".address-form").show();
    });

    // continue to step 2 button, checks to see if address was inputed
    $("#tostep2").click(function() {
        if ($("#new").prop("checked") == true) {
            // new address selected
            let full_name = $("#full_name").val();
            let street_address = $("#street_address").val();
            let city = $("#city").val();
            let province = $("#province").val();
            let postal = $("#postal").val();

            if (full_name == "" || street_address == "" || city == "" || province == "" || postal == "") {
                $("#address_error").html("Must fill in each input");
                return;
            }

            $("#address_error").html("");
            $("#place_full_name").val(full_name);
            $("#place_street_address").val(street_address);
            $("#place_city").val(city);
            $("#place_province").val(province);
            $("#place_postal").val(postal);

            $(".review-address").html(`
            <ul>
                <li>${full_name}</li>
                <li>${street_address}</li>
                <li>${city}</li>
                <li>${province}</li>
                <li>${postal}</li>
            </ul>
            `);

        } else {
            // use existing address selected

            $("#place_full_name").val("");
            $("#place_street_address").val("");
            $("#place_city").val("");
            $("#place_province").val("");
            $("#place_postal").val("");

            $(".review-address").html(currentAddress);
        }

        $(".step-info").hide();
        $("#step2 .step-info").show();
        currentStep = 2;
    });

    $("#tostep3").click(function() {
        $(".step-info").hide();
        $("#step3 .step-info").show();
        $("#place_order_button").prop("disabled", false);
        currentStep = 3;
    });

    /**
     * Gets a json file with the current users
     * address
     * 
     * @param {JSON} json 
     */
    function updateAddress(json) {

        console.log(json);

        if (json.success == "true") {
            if (json.user.address.street_address != null) {
                hasAddress = true;
                
                    
                currentAddress = `
                <ul>
                    <li>${json.user.address.name}</li>
                    <li>${json.user.address.street_address}</li>
                    <li>${json.user.address.city}</li>
                    <li>${json.user.address.province}</li>
                    <li>${json.user.address.postal}</li>
                </ul>
                `;

                $(".address").html(currentAddress);
            } else {
                $("#existing").hide();
                $("#existingLbl").hide();
                $("#new").prop("checked", true);
                $(".address-form").show();
            }
        }
    }

    /**
     * Updates all the products that came from the cart into
     * the order summary step
     * 
     * @param {JSON} json 
     */
    function updateCart(json) {

        console.log(json);

        let products = "";
        let total = 0.00;

        if (json.success == "true") {
            
            for (let i = 0; i < json.count; i++) {

                let price = json.products[i].price - json.products[i].discount;
                total += price * parseInt(json.products[i].quantity);

                products += `
                <div class="item">
                    <div class="item-image"><img src="images/products/${json.products[i].image}"></div>
                    <div class="item-info">
                        <div class="item-name">${json.products[i].name}</div>
                        <div class="item-price">$${parseFloat(price).toFixed(2)}</div>
                        <div class="quantity">Quantity: ${json.products[i].quantity}</div>
                    </div>  
                </div>
                `;

            }


            let tax = total * 0.13;
            let shipping = 0.00; // not inplementing shipping default 0

            $("#products").html(products);
            
            $("#order_summary").html(`
            <div class="left">
                <ul>
                    <li>Items:</li>
                    <li class="hl">Shipping & Handling:</li>
                    <li>Total before tax:</li>
                    <li>GST/HST:</li>
                <ul>
            </div>
            <div class="right">
                <ul>
                    <li>$ ${parseFloat(total).toFixed(2)}</li>
                    <li class="hl">$ ${parseFloat(shipping).toFixed(2)}</li>
                    <li>$ ${parseFloat(total).toFixed(2)}</li>
                    <li>$ ${parseFloat(tax).toFixed(2)}</li>
                <ul>
            </div>
            `);

            $("#total").html(`
            <div class="left">Order Total:</div>
            <div class="right">$ ${parseFloat(total + tax + shipping).toFixed(2)}</div>
            `);


        } else {
            $("#place_order_button").prop("disabled", true);
        }
    }

});