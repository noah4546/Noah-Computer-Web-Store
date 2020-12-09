$(document).ready(function() {

    let error = document.getElementById("error");

    document.forms.register_form.password.addEventListener("keyup", function() {
        verifyPassword(password.value);
    });

    document.forms.register_form.addEventListener("submit", async function(event) {
        event.preventDefault();
        let email = document.forms.register_form.email.value;
        let username = document.forms.register_form.username.value;
        let password = document.forms.register_form.password.value;
        let confirm_password = document.forms.register_form.confirm_password.value;

        if (password != confirm_password) {
            error.innerHTML = "Passwords do not match!";
            return;
        }

        if(!verifyPassword(password)) {
            error.innerHTML = "Passwords do not follow rules";
            return;
        }

        let url = "php/edit/usernameTaken.php?username=" + username;
        let taken = await fetch(url, {credentials: 'include'}).then(response => response.text());

        if (taken != "1") {
            error.innerHTML = taken;
            return;
        }

        url = "php/edit/emailTaken.php?email=" + email;
        taken = await fetch(url, {credentials: 'include'}).then(response => response.text());

        if (taken != "1") {
            error.innerHTML = taken;
            return;
        }

        // If it has passed the checks then it will submit the form
        document.forms.register_form.submit();
    });

    /**
     * Verifys the given password and updates the rules box
     * 
     * @param {String} password 
     */
    function verifyPassword(password) {
        
        let upper = document.getElementById("password_uppercase");
        let lower = document.getElementById("password_lowercase");
        let number = document.getElementById("password_numbers");
        let length = document.getElementById("password_length");

        let upper_regex = /^[a-z0-9]+$/;
        let lower_regex = /^[A-Z0-9]+$/;
        let number_regex = /^[a-zA-Z]+$/;

        let success = true;

        if (!upper_regex.test(password)) {
            upper.style.color = "green";
        } else {
            upper.style.color = "red";
            success = false;
        }

        if (!lower_regex.test(password)) {
            lower.style.color = "green";
        } else {
            lower.style.color = "red";
            success = false;
        }

        if (!number_regex.test(password)) {
            number.style.color = "green";
        } else {
            number.style.color = "red";
            success = false;
        }

        if (password.length < 8 || password.length > 30) {
            length.style.color = "red";
            success = false;
        } else {
            length.style.color = "green";
        }

        if (password.length == 0) {
            upper.style.color = "red";
            lower.style.color = "red";
            number.style.color = "red";
            length.style.color = "red";
            success = false;
        }

        return success;
    }
});