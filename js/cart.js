window.addEventListener("load", function() {

    let cart = document.getElementById("cart");
    let cart_total = document.getElementById("cart_total");

    let product_url = "php/cart/getCart.php";
    fetch(product_url, { credentials: 'include' })
        .then(response => response.json())
        .then(products);

    function products(json) {

        console.log(json);

        let products = "";
        let totalProducts = 0;
        let total = 0.00;

        if (json.success == "true") {
            for (let i = 0; i < json.count; i++) {

                let price = json.products[i].price - json.products[i].discount;
                totalProducts += parseInt(json.products[i].quantity);
                total += price * parseInt(json.products[i].quantity);

                let stock = `<span class="instock">In Stock</span>`;

                products += `
                <div class="cart-item">
                    <div class="cart-item-image"><img src="images/products/${json.products[i].image}"></div>
                    <div class="cart-item-info">
                        <div class="cart-item-name">
                            <a href="product.php?product=${json.products[i].id}">${json.products[i].name}</a>
                        </div>
                        <div class="cart-item-stock">${stock}</div>
                        <div class="cart-item-options">
                            <div class="cart-item-quantity">
                                <form action="cart/updateQuantity.php" method="POST">
                                    <input type="hidden" name="product" value="${json.products[i].id}">
                                    <label for="quantity_${json.products[i].id}">Quantity:</label>
                                    <input type="number" name="quantity" id="quantity_${json.products[i].id}" min="0" max="${json.products[i].stock}" value="${json.products[i].quantity}">
                                    <input type="submit" value="Update">
                                </form>
                            </div>
                            <div class="cart-item-delete">
                                <form action="cart/deleteItem.php" method="POST">
                                    <input type="hidden" name="product" value="${json.products[i].id}">
                                    <input type="submit" value="Delete">
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="cart-item-price">$${parseFloat(price).toFixed(2)}</div>
                </div>
                `;

            }
        }

        let items = `${totalProducts} item`;
        if (totalProducts > 1) {
            items = `${totalProducts} items`;
        }

        cart.innerHTML = products;
        cart_total.innerHTML = `
        <span class="subtotal">Subtotal (${items}):</span>
        <span class="total">$${parseFloat(total).toFixed(2)}</span>
        `;
    }

});