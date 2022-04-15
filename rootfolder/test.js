let userId=0;
let remember = true;

// Value that will store the userId of the logged in session.
var currentUser = 0;


function login(form, e) {
    e.preventDefault();
    e.stopPropagation();
    //document.write('<div>Login successful</div>');
    userId = apiHandler("Login", JSON.stringify(
        {
            username: form.username.value,
            password: form.password.value
        }
    )).ID;


    if (userId < 1 || userId === undefined) {


    }
    if(form.loginType.value == "student"){
        userId = apiHandler("Login", JSON.stringify(
            {
                username: form.username.value,
                password: form.password.value
            }
        )).ID;

        if (userId != undefined) {
            localStorage.setItem("currentUser", userId);
            window.location.assign("student.html");
        }
        else{
            alert('Credentials invalid.');
        }

    }

    else if(form.loginType.value == "admin"){
        userId = apiHandler("LoginA", JSON.stringify(
            {
                username: form.username.value,
                password: form.password.value
            }
        )).ID;

        if (userId != undefined) {
            localStorage.setItem("currentUser", userId);
            window.location.assign("admin.html");
        }
        else{
            alert('Credentials invalid.');
        }

    }
    else if(form.loginType.value == "superadmin"){
        userId = apiHandler("LoginSA", JSON.stringify(
            {
                username: form.username.value,
                password: form.password.value
            }
        )).ID;

        if ( userId != undefined) {
            localStorage.setItem("currentUser", userId);
            window.location.assign("superadmin.html");
        }
        else{
            alert('Credentials invalid.');
        }

    }
    else{
        alert('Credentials invalid.');
    }

}

// Function that returns the user id of the logged in user. 
function getCurrentUser() {
    return localStorage.getItem("currentUser");
}

function findEvents( e){
    e.preventDefault();
    e.stopPropagation();

    //let eventID = 0;
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

    //let eventID = 0;
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

    //let eventID = 0;
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
    //let eventID = 0;
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
    //let eventID = 0;
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

function createUni(form, e){
    e.preventDefault();
    e.stopPropagation();
    let t = "";

    //let eventID = 0;
    //document.write('<div>Login successful</div>');
    //document.write(userId);
    //document.write(userId);
    //document.write(form.uniName.value);

    if (form.uniName.value == "") {
        //$("#usernameResult").text("Please enter a username");
        alert('University Name Empty');
        t = "dd";
        return;
    }

    t = ApiHandler("CreateUni", JSON.stringify(
        {
            uni_superadmin_ID: 2, //userId,
            name: form.uniName.value

        }
    )).error;

    //document.write(t);
    if(t == ""){
        return form.uniName.value;
    }
    else{
        alert("You've already made a University or the Unversity name is already taken.");
    }
        //document.write("hellooo");


}

function findEventsA( e){
    e.preventDefault();
    e.stopPropagation();
    //let eventID = 0;
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
    let test = "";

    // No username was entered
    if (form.username.value == "") {
        //$("#usernameResult").text("Please enter a username");
        alert('Username Empty');
    } else {
        //$("#usernameResult").text("");
    }

    if (form.password.value == "") {
       // $("#passwordResult").text("Please enter a password");
        error = true; alert('Password Empty');
    } else if (form.password.value != form.passwordConfirm.value) {
        //$("#passwordResult").text("Passwords do not match");
        alert('Passwords do not match');
        error = true;
    } else {
        //$("#passwordResult").text("");
        //document.write("?xx?");
    }

    if (error) return;

    // error = apiHandler("Signup", JSON.stringify({
    //     username: form.username.value,
    //     password: form.password.value
    // })).error;

    //alert('test!');
    if(form.signupType.value == "student"){
        test = apiHandler("Signup", JSON.stringify(
            {
                username: form.username.value,
                password: form.password.value
            }
        )).error;
            //document.write(test);
        if (test == "") {
            //alert("Account Successfully Made");
            window.location.assign("login.html");
        }
        else{
            alert('Username/Password invalid.');
        }

    }

    else if(form.signupType.value == "admin"){
        test = apiHandler("SignupA", JSON.stringify(
            {
                username: form.username.value,
                password: form.password.value
            }
        )).error;

        if (test == "") {
            window.location.assign("login.html");
        }
        else{
            alert('Username/Password invalid.');
        }

    }
    else if(form.signupType.value == "superadmin"){
        test = apiHandler("SignupSA", JSON.stringify(
            {
                username: form.username.value,
                password: form.password.value
            }
        )).error;

        if ( test == "") {
            window.location.assign("login.html");
        }
        else{
            alert('Username/Password invalid.');
        }

    }
    else{
        alert('Please Select an Account Type.');
    }
    //document.write("We gucci");
    // Log in new user
    // $("#signup-modal").modal('toggle');
    // saveCookie();
    // $("#login-modal").modal('toggle');
    // searchContacts("All", "");
}
