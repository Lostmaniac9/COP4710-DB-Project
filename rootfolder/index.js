// When page is loaded
// Check if user is logged in
// Otherwise open Login window
$(document).ready(function () {

    //addBlur();
    $('#login-modal').modal('toggle');
    //$("#signup-modal").modal('toggle');
});

// Handle api calls and responses
function apiHandler(api, jsonPayload) {
let xhr = new XMLHttpRequest();
let url = '' + api + '.php';
document.write(jsonPayload);
xhr.open("POST", url, false);
xhr.setRequestHeader("Content-Type", "application/json");
xhr.send(jsonPayload);

return JSON.parse(xhr.responseText);
}