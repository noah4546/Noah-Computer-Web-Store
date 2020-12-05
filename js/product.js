window.addEventListener("load", function() {

    let product_id = document.getElementById("product_id").innerHTML;

    let product_url = "php/products/getProductById.php?id=" + product_id;
    fetch(product_url, { credentials: 'include' })
        .then(response => response.json())
        .then(loadProduct);

    function loadProduct(json) {

        console.log(json);

        if (json.success == "true") {

            let image = `<img src="images/products/${json.product.image}">`;
            let price = `${json.product.price}`;
            let short_description = json.product.short_description;
            let long_description = json.product.long_description;
            let quantity = json.product.quantity;

            let stock = `<span class="instock">In Stock</span>`;
            if (quantity == 0) {
                stock = `<span class="outstock">Out of Stock</span>`;
            } else if (quantity <= 50) {
                stock = `<span class="lowstock">Low Stock, ${quantity} left</span>`;
            }

            if (json.product.discount > 0) {

                let newPrice = json.product.price - json.product.discount;
                let discountPercent = (json.discount.discount - json.product.price) * 100;

                price = `
                    <span style='text-decoration: line-through;'>$${json.product.price}</span>
                    <span>$${newPrice}</span>
                    <span class="discount">${discountPercent}% off</span>
                `;
            }

            let stockOptions = "";
            let numOfOptions = 10;

            if (quantity < 10) {
                numOfOptions = quantity;
            }

            for (let i = 0; i < numOfOptions; i++) {
                stockOptions += `<option value="${i}">${i}</option>`;
            }

            let product_buy = `
                <span>${price}</span>
                <span>${stock}</span>
                <form action="addToCart" method="POST">
                    <label for="cart_quantity">Quantity:</label>
                    <select name="quantity" id="cart_quantity">
                        ${stockOptions}
                    </select>
                    <input type="submit" value="Add to Cart">
                </form>
            `

            document.getElementById("product_image").innerHTML = image;
            document.getElementById("product_price").innerHTML = price;
            document.getElementById("short_description").innerHTML = short_description;
            document.getElementById("product_buy").innerHTML = product_buy;
            document.getElementById("long_description").innerHTML = long_description;
        }
    }

});