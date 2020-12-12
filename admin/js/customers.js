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

    // when the user types in the filter input it will refine the items shown
    filter.addEventListener("keyup", function() {

        let users_url = "php/getAllUsers.php?filter=" + filter.value;
        fetch(users_url, { credentials: 'include' })
            .then(response => response.json())
            .then(displayUsers);

    });

    // gets all of the users (no filter)
    let users_url = "php/getAllUsers.php";
    fetch(users_url, { credentials: 'include' })
        .then(response => response.json())
        .then(displayUsers);

    /**
     * Takes in a JSON array and formats out to
     * the screen a user-freindly version of the
     * sql table
     * 
     * @param {JSON} json 
     */
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

            // set all the options a admin can do on the user
            let activeOption = `<option value="activate">Activate User</option>`;
            let adminOption = `<option value="op">Add Admin</option>`;

            if (user.active == 1) {
                activeOption = `<option value="deactivate">Deactivate User</option>`;
            }
            if (user.admin == 1) {
                adminOption = `<option value="deop">Remove Admin</option>`;
            }

            let options = `
            <form action="php/userOptions.php" method="POST" class="options">
                <input type="hidden" name="user" value="${user.id}">
                <select name="option">
                    <option disabled selected value>Select an option</option>
                    ${activeOption}
                    ${adminOption}
                    <option value="delete">Delete User</option>
                </select>

                <label for="confirm_${user.id}">Confirm</label>
                <input type="checkbox" id="confirm_${user.id}" required>
                <input type="submit">
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