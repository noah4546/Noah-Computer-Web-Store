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

    let orders_url = "php/getOrders.php";
    fetch(orders_url, {credentials: 'include'})
        .then(response => response.json())
        .then(populateOrders);

    function populateOrders(json) {

        console.log(json);

        if (json.success == "true") {   
            
            let orders = "";

            for (let i = 0; i < json.count; i++) {

                orders += `
                <div class="order">
                    <div class="order-header">
                        <div class="order-header-date">
                            <div class="order-header-heading">ORDER PLACED</div>
                            <div class="order-header-info">${json.orders[i].date}</div>
                        </div>
                        <div class="order-header-total">
                            <div class="order-header-heading">TOTAL</div>
                            <div class="order-header-info">$${parseFloat(json.orders[i].total).toFixed(2)}</div>
                        </div>
                        <div class="order-header-ship">
                            <div class="order-header-heading">SHIP TO</div>
                            <div class="order-header-info">
                            <ul>
                                <li>${json.orders[i].address.name}</li>
                                <li>${json.orders[i].address.street_address}</li>
                                <li>${json.orders[i].address.city}</li>
                                <li>${json.orders[i].address.province}</li>
                                <li>${json.orders[i].address.postal}</li>
                            </ul>
                            </div>
                        </div>
                        <div class="order-header-number">
                            <div class="order-header-heading">ORDER NUMBER</div>
                            <div class="order-header-info">#${json.orders[i].id}</div>
                        </div>
                    </div>
                    <div class="order-main">
                        <div class="order-status">${json.orders[i].status}</div>
                `;

                for (let j = 0; j < json.orders[i].count; j++) {

                    let current = json.orders[i].products[j];
                    let price = current.price - current.discount

                    orders += `
                        <div class="order-item">
                            <div class="order-item-image"><img src="images/products/${current.image}"></div>
                            <div class="order-item-info">
                                <div class="order-item-name">${current.name}</div>
                                <div class="order-item-qty">Quantity: ${current.quantity}</div>
                                <div class="price">$${parseFloat(price).toFixed(2)}</div>
                            </div>
                        </div>
                    `;

                }

                orders += `
                    </div>
                </div>
                `;
            }

            $("#orders").html(orders);
            $("#number_orders").html(json.count);
        } else {
            $("orders").html("Failed loading orders");
        }
    }

});