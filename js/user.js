window.addEventListener("load", function() {


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
                        <li>${json.user.address.street_address}</li>
                        <li>${json.user.address.city}</li>
                        <li>${json.user.address.province}</li>
                        <li>${json.user.address.postal}</li>
                    </ul>
                    `;

                    document.getElementById("street_address").placeholder = json.user.address.street_address;
                    document.getElementById("city").placeholder = json.user.address.city;
                    document.getElementById("province").placeholder = json.user.address.province;
                    document.getElementById("postal").placeholder = json.user.address.postal;
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

    let ids = ["username", "email", "password", "address"];

    for (let i = 0; i < ids.length; i++) {
        document.getElementById(`edit_${ids[i]}`).addEventListener("click", function() {
            showHideForm(ids[i]);
        });
    }

    function showHideForm(row) {

        console.log(row);

        let edit_button = document.getElementById(`edit_${row}`);
        let form = document.getElementById(`form_${row}`);
        let current = document.getElementById(`current_${row}`);

        if (edit_button.innerHTML == "Edit") {

            for (let i = 0; i < ids.length; i++) {
                document.getElementById(`edit_${ids[i]}`).innerHTML = "Edit";
                document.getElementById(`form_${ids[i]}`).style.display = "none";
                document.getElementById(`current_${ids[i]}`).style.display = "block";
            }

            edit_button.innerHTML = "Cancel";
            form.style.display = "block";
            current.style.display = "none";

        } else {

            edit_button.innerHTML = "Edit";
            form.style.display = "none";
            current.style.display = "block";

        }
    }


    /*
    let username_form = document.getElementById('username_form');
    let edit_username = document.getElementById('edit_username');
    let cancel_username = document.getElementById('cancel_username');
    let save_username = document.getElementById('save_username');

    function show_edit_form(current_id, form_id, edit_id, cancel_id, save_id) {

        let current = document.getElementById(current_id);
        let form = document.getElementById(form_id);
        let edit_btn = document.getElementById(edit_id);
        let cancel_btn = document.getElementById(cancel_id);
        let save_btn = document.getElementById(save_id);

    }
    */
    
});
