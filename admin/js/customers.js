$(document).ready(function() {

    let filter = document.getElementById("query");

    filter.addEventListener("keyup", function() {

        let users_url = "php/getAllUsers.php?filter=" + filter.value;
        fetch(users_url, { credentials: 'include' })
            .then(response => response.json())
            .then(displayUsers);

    });

    let users_url = "php/getAllUsers.php";
    fetch(users_url, { credentials: 'include' })
        .then(response => response.json())
        .then(displayUsers);

    function displayUsers(json) {

        console.log(json);

        let users = `
        <table>
            <tr>
                <th>Id</th>
                <th>Username</th>
                <th>Email</th>
                <th>Address</th>
                <th>Active</th>
                <th>Admin</th>
                <th>Created</th>
                <th>Options</th>
            </tr>
        `;

        for (let i = 0; i < json.count; i++) {

            let user = json.users[i];
            let address = "";

            if (user.address.street_address == null) {
                address = "No address set";
            } else {
                address = `
                <ul>
                    <li>${user.address.name}</li>
                    <li>${user.address.street_address}</li>
                    <li>${user.address.city}</li>
                    <li>${user.address.province}</li>
                    <li>${user.address.postal}</li>
                </ul>
                `;
            }

            let activeOption = `<option value="activate">Activate User</option>`;
            let adminOption = `<option value="op">Add Admin</option>`;

            if (user.active == 1) {
                activeOption = `<option value="deactivate">Deactivate User</option>`;
            }
            if (user.admin == 1) {
                adminOption = `<option value="deop">Remove Admin</option>`;
            }

            let options = `
            <form action="userOptions" method="POST">
                <input type="hidden" name="user" value="${user.id}">
                <select name="option">
                    <option disabled selected value>Select an option</option>
                    ${activeOption}
                    ${adminOption}
                    <option value="delete">Delete User</option>
                </select>
            </form>
            `;

            users += `
            <tr>
                <td>${user.id}</td>
                <td>${user.username}</td>
                <td>${user.email}</td>
                <td>${address}</td>
                <td>${user.active}</td>
                <td>${user.admin}</td>
                <td>${user.create}</td>
                <td class="options">${options}</td>
            </tr>
            `;

        }

        users += `
        </table>
        `;

        $(".customers").html(users);
    }

});