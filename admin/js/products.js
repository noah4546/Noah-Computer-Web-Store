window.addEventListener("load", function() {

    let products_div = document.getElementById("products");
    let query = document.getElementById("query");

    query.addEventListener("keyup", function() {

        let search_url = "../php/products/getProducts.php?query=" + query.value;
        fetch(search_url, { credentials: 'include' })
            .then(response => response.json())
            .then(products);

    });

    let product_url = "../php/products/getProducts.php";
    fetch(product_url, { credentials: 'include' })
        .then(response => response.json())
        .then(products);

    function products(json) {

        console.log(json);

        let products = "";

        if (json.success == "true") {

            for (let i = 0; i < json.count; i++) {

                products += `
                <a href="editProduct.php?product=${json.products[i].id}">
                <div class="product-item">
                    <div>${json.products[i].id}</div>
                    <div>${json.products[i].name}</div>
                    <div>${json.products[i].category}</div>
                    <div>$${json.products[i].price}</div>
                    <div>$${json.products[i].discount}</div>
                    <div>${json.products[i].quantity}</div>
                    <div>${json.products[i].status}</div>
                </div>
                </a>
                `;
            }
        }

        products_div.innerHTML = products;
    }

});