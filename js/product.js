$(document).ready(function() {

    let product_id = document.getElementById("product_id").innerHTML;

    let product_url = "php/products/getProductById.php?id=" + product_id;
    fetch(product_url, { credentials: 'include' })
        .then(response => response.json())
        .then(loadProduct);

    function loadProduct(json) {

        console.log(json);

        if (json.success == "true") {

            let name = json.product.name;
            let image = `<img src="images/products/${json.product.image}">`;
            let price = `$${parseFloat(json.product.price).toFixed(2)}`;
            let priceAndDiscount = price;
            let short_description = json.product.short_description;
            let long_description = json.product.long_description;
            let quantity = json.product.quantity;

            let disabled = "";

            let stock = `<span class="instock">In Stock</span>`;
            if (quantity == 0) {
                stock = `<span class="outstock">Out of Stock</span>`;
                disabled = "disabled";
            } else if (quantity <= 50) {
                stock = `<span class="lowstock">Low Stock, ${quantity} left</span>`;
            }

            if (json.product.discount > 0) {

                let newPrice = json.product.price - json.product.discount;
                let discountPercent = (json.product.discount / json.product.price) * 100;

                price = `$${parseFloat(newPrice).toFixed(2)}`;
                priceAndDiscount = `
                    <span style='text-decoration: line-through;'>$${parseFloat(json.product.price).toFixed(2)}</span>
                    <span>$${parseFloat(newPrice).toFixed(2)}</span>
                    <span class="discount">${parseFloat(discountPercent).toFixed(0)}% off</span>
                `;
            }

            let stockOptions = "";
            let numOfOptions = 10;

            if (quantity < 10) {
                numOfOptions = quantity;
            }

            for (let i = 1; i <= numOfOptions; i++) {
                stockOptions += `<option value="${i}">${i}</option>`;
            }

            let product_buy = `
                <div class="price">${price}</div>
                <div id="product_buy_stock">${stock}</div>
                <div class="product-form">
                    <form action="php/cart/addToCart.php" method="POST">
                        <input type="hidden" name="product" value="${json.product.id}">
                        <label for="cart_quantity">Quantity:</label>
                        <select name="quantity" id="cart_quantity">
                            ${stockOptions}
                        </select>
                        <input type="submit" value="Add to Cart" ${disabled}>
                    </form>
                </div>
            `

            document.getElementById("product_name").innerHTML = name;
            document.getElementById("product_image").innerHTML = image;
            document.getElementById("product_price").innerHTML = priceAndDiscount;
            document.getElementById("short_description").innerHTML = short_description;
            document.getElementById("product_buy").innerHTML = product_buy;
            document.getElementById("long_description").innerHTML = long_description;
        }
    }

});