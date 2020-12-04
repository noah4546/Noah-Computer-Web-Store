window.addEventListener("load", function() {

    let category_table = document.getElementById("product_category_table");
    let product_table = document.getElementById("products_table");

    let product_url = "php/products/getAllProducts.php";
    let category_url = "php/products/getAllCategories.php";

    product_table.innerHTML = `
    <tr>
        <th>Product id</th>
        <th>Catagory</th>
        <th>Name</th>
        <th>Price</th>
        <th>Discount</th>
        <th>Quantity</th>
        <th>Status</th>
    </tr>
    `;

    category_table.innerHTML = `
    <tr>
        <th>Category id</th>
        <th>Category name</th>
        <th>Category description</th>
    </tr>
    `;
   
    fetch(product_url, { credentials: 'include' })
        .then(response => response.json())
        .then(products);

    fetch(category_url, { credentials: 'include' })
        .then(response => response.json())
        .then(category);

    function products(json) {
        if (json.success == "true") {

            for (let i = 0; i < json.count; i++) {

                product_table.innerHTML += `
                <tr>
                    <td>${json.products[i].id}</td>
                    <td>${json.products[i].category}</td>
                    <td>${json.products[i].name}</td>
                    <td>$${json.products[i].price}</td>
                    <td>$${json.products[i].discount}</td>
                    <td>${json.products[i].quantity}</td>
                    <td>${json.products[i].status}</td>
                </tr>
                `;
            }
        }
    }

    function category(json) {
        console.log(json);
        if (json.success == "true") {

            for (let i = 0; i < json.count; i++) {

                category_table.innerHTML += `
                <tr>
                    <td>${json.category[i].id}</td>
                    <td>${json.category[i].name}</td>
                    <td>${json.category[i].description}</td>
                </tr>
                `;
            }
        }
    }

});