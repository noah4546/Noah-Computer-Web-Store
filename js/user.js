window.addEventListener("load", function() {

    let user_info = document.getElementById("user_info");

    let url = "php/getUserInfo.php";
    fetch(url, {credentials: 'include'})
        .then(response => response.json)
        .then(function(json) {



        });
});
