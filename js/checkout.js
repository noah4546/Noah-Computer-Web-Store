$(document).ready(function() {

    let user_url = "php/getUserInfo.php";
    fetch(user_url, {credentials: 'include'})
        .then(response => response.json())
        .then(updateAddress);

    let cart_url = "php/cart/getCart.php";
    fetch(cart_url, {credentials: 'include'})
        .then(response => response.json())
        .then(updateCart);

    function updateAddress(json) {

        console.log(json);

        if (json.success == "true") {
            if (json.user.address.street_address != null) {
                $("#address").html(`
                <ul>
                    <li>${json.user.address.name}</li>
                    <li>${json.user.address.street_address}</li>
                    <li>${json.user.address.city}</li>
                    <li>${json.user.address.province}</li>
                    <li>${json.user.address.postal}</li>
                </ul>
                `);
                $("#place_order_button").prop("disabled", false);
            }
        }
    }

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