$(document).ready(function() {

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

                let product = json.products[i];

                products += `
                <div class="product-item">
                    <div>${product.id}</div>
                    <div><img src="../images/products/${product.image}"></div>
                    <div>${product.name}</div>
                    <div>${product.category}</div>
                    <div>$${product.price}</div>
                    <div>$${product.discount}</div>
                    <div>${product.quantity}</div>
                    <div>${product.status}</div>
                    <div>
                        <form action="php/productOptions.php" method="POST" class="options">
                            <input type="hidden" name="product" value="${product.id}">
                            <select name="option">
                                <option disabled selected value>Select an option</option>
                                <option value="edit">Edit Product</option>
                                <option value="feature">Set Featured</option>
                                <option value="avail">Set Available</option>
                                <option value="unavail">Set Unavalible</option>
                                <option value="discontinue">Set Discontinued</option>
                            </select>
            
                            <input type="submit">
                        </form>
                    </div>
                </div>
                `;
            }
        }

        products_div.innerHTML = products;
    }

});