let userId = 0;
let remember = true;

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
    } else {
        document.write('<div>Login successful</div>');
        document.write(userId);
        //$('#login-modal').modal('toggle');
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
        document.write("L");
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
        error = true;document.write("???");
    } else if (form.password.value != form.passwordConfirm.value) {
        //$("#passwordResult").text("Passwords do not match");
        document.write("?x?");
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
    document.write("We gucci");
    // Log in new user
    // $("#signup-modal").modal('toggle');
    // saveCookie();
    // $("#login-modal").modal('toggle');
    // searchContacts("All", "");
}



