window.addEventListener("load", function() {

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

                let name = json.products[i].name;

                if (name.length > 60) {
                    name = name.substring(0, 60) + "...";
                }

                products += `
                <a href="product.php?product=${json.products[i].id}">
                <div class="product-item">
                    <div class="product-image"><img src="images/products/${json.products[i].image}"></div>
                    <div class="product-name">${name}</div>
                    <div class="product-price">$${json.products[i].price-json.products[i].discount}</div>
                </div>
                </a>
                `;
            }
        }

        products_div.innerHTML = products;
    }

});