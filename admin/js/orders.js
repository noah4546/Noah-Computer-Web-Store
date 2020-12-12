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

    let filter = document.getElementById("query");

    filter.addEventListener("keyup", function() {

        let orders_url = "php/getAllOrders.php?filter=" + filter.value;
        fetch(orders_url, { credentials: 'include' })
            .then(response => response.json())
            .then(displayOrders);

    });

    let orders_url = "php/getAllOrders.php";
    fetch(orders_url, { credentials: 'include' })
        .then(response => response.json())
        .then(displayOrders);

    function displayOrders(json) {

        console.log(json);

        let orders = `
        <table>
            <tr>
                <th>Id</th>
                <th>Total</th>
                <th>Date</th>
                <th>Ship to</th>
                <th>Products</th>
                <th>Status</th>
                <th>Options</th>
            </tr>
        `;

        for (let i = 0; i < json.count; i++) {

            let order = json.orders[i];
            let address = "";

            if (order.address.street_address == null) {
                address = "No address set";
            } else {
                address = `
                <ul>
                    <li>${order.address.name}</li>
                    <li>${order.address.street_address}</li>
                    <li>${order.address.city}</li>
                    <li>${order.address.province}</li>
                    <li>${order.address.postal}</li>
                </ul>
                `;
            }

            let options = `
            <form action="php/orderOptions.php" method="POST" class="options">
                <input type="hidden" name="order" value="${order.id}">
                <select name="option">
                    <option disabled selected value>Select an option</option>
                    <option value="processing">Set Processing</option>
                    <option value="shipped">Set Shipped</option>
                    <option value="delivered">Set Delivered</option>
                    <option value="backorder">Set Backorder</option>
                    <option value="canceled">Cancel Order</option>
                </select>
                <input type="submit">
            </form>
            `;
            
            let products_url = `php/orderInfo.php?order=${order.id}`;
            fetch(products_url, {credentials: 'include'})
                .then(response => response.json())
                .then(fillProducts);


            orders += `
            <tr>
                <td>${order.id}</td>
                <td class="price">$${parseFloat(order.total).toFixed(2)}</td>
                <td>${order.date}</td>
                <td>${address}</td>
                <td id="products_${order.id}"></td>
                <td>${order.status}</td>
                <td class="options">${options}</td>
            </tr>
            `;

        }

        orders += `
        </table>
        `;

        $(".orders").html(orders);
    }

    function fillProducts(json) {
        if (json.success == "true") {

            console.log(json);

            let products = "<ul>";

            for (let i = 0; i < json.count; i++) {
                
                let product = json.products[i];

                let name = product.name;
                let price = product.price - product.discount;

                if (name.length > 40) {
                    name = name.substring(0, 40) + "...";
                }

                products += `
                <li>
                    <ul>
                        <li>Qty: ${product.quantity}<li>
                        <li>${name}</li>
                        <li class="price">$${parseFloat(price).toFixed(2)}</li>
                    <ul>
                </li>
                `;

            }

            products += "</ul>";

            $(`#products_${json.id}`).html(products);
        }
    }

});