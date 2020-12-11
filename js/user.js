$(document).ready(function() {


    let url = "php/getUserInfo.php";
    fetch(url, {credentials: 'include'})
        .then(response => response.json())
        .then(function(json) {
            if (json.success == "true") {
                
                user_info = json;
                console.log(user_info);

                let address = "Not Set, click edit to add an address.";

                if (json.user.address.street_address != null) {
                    address = 
                    `
                    <ul>
                        <li>${json.user.address.name}</li>
                        <li>${json.user.address.street_address}</li>
                        <li>${json.user.address.city}</li>
                        <li>${json.user.address.province}</li>
                        <li>${json.user.address.postal}</li>
                    </ul>
                    `;

                    document.getElementById("full_name").value = json.user.address.name;
                    document.getElementById("street_address").value = json.user.address.street_address;
                    document.getElementById("city").value = json.user.address.city;
                    document.getElementById("province").value = json.user.address.province;
                    document.getElementById("postal").value = json.user.address.postal;
                }

                document.getElementById("current_username").innerHTML = json.user.username;
                document.getElementById("current_email").innerHTML = json.user.email;
                document.getElementById("current_address").innerHTML = address;
                document.getElementById("created").innerHTML = json.user.created;

                document.getElementById("username").placeholder = json.user.username;
                document.getElementById("email").placeholder = json.user.email;

            } else {
                console.log(json.error);
            }
        });


    $("button").click(function() {

        if ($(this).html() == "Edit") {
            $(this).html("Cancel");
        } else {
            $(this).html("Edit");
        }

        let div = $(this).parent('td').parent('tr').children();
        
        // Toggle form
        div.children("form")
            .toggle();

        // Toggle current value
        div.children("div")
            .toggle();

    }); 
});
