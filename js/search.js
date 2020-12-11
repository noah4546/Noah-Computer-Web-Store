$(document).ready(function() {

    let products_div = document.getElementById("products");
    let search = document.getElementById("search");

    search.addEventListener("keyup", function() {

        let search_url = "php/products/getProducts.php?query=" + search.value;
        fetch(search_url, { credentials: 'include' })
            .then(response => response.json())
            .then(products);

    });

    let product_url = "php/products/getProducts.php?query=" + search.value;
    fetch(product_url, { credentials: 'include' })
        .then(response => response.json())
        .then(products);

    function products(json) {

        console.log(json);

        let products = "";

        if (json.success == "true") {

            for (let i = 0; i < json.count; i++) {

                let product = json.products[i];
                
                let name = product.name;
                let price = `$${parseFloat(product.price).toFixed(2)}`;
                let priceAndDiscount = price;
                
                let stock = `<span class="instock">In Stock</span>`;
                if (product.status == "unavailable") {
                    stock = `<span class="outstock">Unavailable</span>`;
                } else if (product.status == "discontinued") {
                    stock = `<span class="outstock">Discontinued</span>`;
                } else if (product.quantity == 0) {
                    stock = `<span class="outstock">Out of Stock</span>`;
                } else if (product.quantity <= 50) {
                    stock = `<span class="lowstock">Low Stock, ${product.quantity} left</span>`;
                }

                if (name.length > 60) {
                    name = name.substring(0, 60) + "...";
                }

                if (product.discount > 0) {

                    let newPrice = product.price - product.discount;
                    let discountPercent = (product.discount / product.price) * 100;
    
                    price = `$${parseFloat(newPrice).toFixed(2)}`;
                    priceAndDiscount = `
                        <div style='text-decoration: line-through;'>$${parseFloat(product.price).toFixed(2)}</div>
                        <div>$${parseFloat(newPrice).toFixed(2)}</div>
                        <div class="discount">${parseFloat(discountPercent).toFixed(0)}% off</div>
                    `;
                }

                products += `
                <a href="product.php?product=${json.products[i].id}">
                <div class="product-item">
                    <div class="product-image"><img src="images/products/${json.products[i].image}"></div>
                    <div class="product-name">${name}</div>
                    <div class="product-stock">${stock}</div>
                    <div class="product-price price">${priceAndDiscount}</div>
                </div>
                </a>
                `;
            }
        }

        products_div.innerHTML = products;
    }

});