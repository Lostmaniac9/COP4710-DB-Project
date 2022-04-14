var userId = 0;
var remember = true;

function login(form, e) {
    e.preventDefault();
    e.stopPropagation();
    //document.write('<div>Login successful</div>');
    userId = apiHandler("Login", JSON.stringify(
        {
            username: form.username.value,
            password: form.password.value
        }
    )).UID;

    if (userId < 1 || userId === undefined) {
        //$("#loginResult").text("User/Password combination incorrect");
        //document.write('<div>Testing</div>');
        document.write("L");
        alert('Credentials invalid.');
    } if (form.loginType.value == "student") {
        window.location.assign("student.html");
    } else if (form.loginType.value == "admin") {
        window.location.assign("admin.html");
    } else if (form.loginType.value == "superadmin") {
        window.location.assign("superadmin.html");
    } else {
        document.write('<div>Login successful</div>');
        document.write(userId);
        //$('#login-modal').modal('toggle');
        alert("Please select a role.");
    }
}

function findEvents( e){
    e.preventDefault();
    e.stopPropagation();

    let eventID = 0;
    //document.write('<div>Login successful</div>');
    list = ApiHandler("FindEvents", JSON.stringify(
        {
        }
    )).results;
    if(list == undefined){
        list = [];
    }
    document.write("test");
    return list;
    document.write("test");
}

function findUnapproved( e){
    e.preventDefault();
    e.stopPropagation();

    let eventID = 0;
    //document.write('<div>Login successful</div>');
    list = ApiHandler("FindUnapproved", JSON.stringify(
        {
        }
    )).results;
    if(list == undefined){
        list = [];
    }
    //document.write("test");
    return list;
    document.write("test");
}

function findSpecific( e, sel){
    e.preventDefault();
    e.stopPropagation();

    let eventID = 0;
    //document.write(sel);
    //document.write('<div>Login successful</div>');
    list = ApiHandler("FindSpecificEvent", JSON.stringify(
        {
            event_ID: sel
        }
    )).results;
    if(list == undefined){
        list = [];
    }
    //document.write("test");
    return list;

}

function findCoords( e, sel){
    e.preventDefault();
    e.stopPropagation();
    //document.write(sel);
    let eventID = 0;
    //document.write('<div>Login successful</div>');
    list = ApiHandler("FindCoords", JSON.stringify(
        {
            loc_name: sel
        }
    )).results;
    if(list == undefined){
        list = [];
    }//document.write(testing);
    //document.write("testing");
    return list;
    document.write("test");
}

function approve(e, sel){
    e.preventDefault();
    e.stopPropagation();
    //document.write(sel);
    let test = "test";
    //document.write('<div>Login successful</div>');
    test = ApiHandler("ApproveEvent", JSON.stringify(
        {
            event_ID: sel
        }
    )).error;
    //document.write(testing);
    //document.write("testing");
    return test;
}
function findLocations( e){
    e.preventDefault();
    e.stopPropagation();
    let eventID = 0;
    //document.write('<div>Login successful</div>');
    list = ApiHandler("FindLocations", JSON.stringify(
        {
        }
    )).results;
    if(list == undefined){
        list = [];
    }

    return list;
    document.write("test");
}

function findEventsA( e){
    e.preventDefault();
    e.stopPropagation();
    let eventID = 0;
    //document.write('<div>Login successful</div>');
    list = ApiHandler("FindPubEventsA", JSON.stringify(
        {
        }
    )).results;
    if(list == undefined){
        list = [];
    }
    return list;
    document.write("test");
}
function signup(form, e) {
    e.preventDefault();
    e.stopPropagation();
    let error = false;

    // No username was entered
    if (form.username.value == "") {
        //$("#usernameResult").text("Please enter a username");
        alert("Please enter a username.");
        error = true;
    } else {
        //$("#usernameResult").text("");
    }

    // Invalid email
    // if (!form.email.value.includes("@")) {
    //     //$("#emailResult").text("Please enter an email");
    //     document.write("?");
    //     error = true;
    // } else {
    //     //$("#emailResult").text("");
    //     document.write("??");
    // }

    // No password was entered or passwords do not match
    if (form.password.value == "") {
       // $("#passwordResult").text("Please enter a password");
       alert("Please enter a password.");
        error = true;
    } else if (form.password.value != form.passwordConfirm.value) {
        //$("#passwordResult").text("Passwords do not match");
        document.write("?x?");
        error = true;
    } else if (form.loginType.value == "") {
        alert("Please select an account type.");
        error = true;
    } else {
        //$("#passwordResult").text("");
        //document.write("?xx?");
    }

    if (error) return;

    userId = apiHandler("Signup", JSON.stringify({
        username: form.username.value,
        password: form.password.value
     })).newUserID;

    if (form.loginType.value == "student") {
        window.location.assign("student.html");
    } else if (form.loginType.value == "admin") {
        window.location.assign("admin.html");
    } else if (form.loginType.value == "superadmin") {
        window.location.assign("superadmin.html");
    } else {
        alert("Please choose a role.");
    }



    return newUserID;
    //document.write("We gucci");
    // Log in new user
    // $("#signup-modal").modal('toggle');
    // saveCookie();
    // $("#login-modal").modal('toggle');
    // searchContacts("All", "");
}
