function CheckPassword() {
    var inputtxt = document.getElementById('password').value;
    var passw = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{7,}$/;
    if (inputtxt.match(passw)) {
        document.getElementById('password').style.color = "green";
        document.getElementById('errorPass').style.display = "none";
        return true;
    } else {
        document.getElementById('password').style.color = "red";
        document.getElementById('errorPass').style.display = "block";
        return false;
    }
}

function CheckUsername() {
    var inputtxt = document.getElementById('username').value;
    inputtxt = inputtxt.toLowerCase();
    var passw = /^[A-Za-z0-9_]\w{7,25}$/;
    defaultUser = ['administrator', 'support', 'root', 'postmaster', 'webmaster', 'security', 'admin'];
    if (inputtxt.match(passw) && defaultUser.indexOf(inputtxt) < 0) {
        document.getElementById('username').style.color = "green";
        document.getElementById('errorUser').style.display = "none";
        return true;
    } else {
        document.getElementById('username').style.color = "red";
        document.getElementById('errorUser').style.display = "block";
        return false;
    }
}

function CheckRePassword() {
    var inputtxt = document.getElementById('re_pass').value
    var passw = document.getElementById('password').value;
    if (inputtxt == passw) {
        document.getElementById('re_pass').style.color = "green";
        document.getElementById('errorRePass').style.display = "none";
        return true;
    } else {
        document.getElementById('re_pass').style.color = "red";
        document.getElementById('errorRePass').style.display = "block";
        return false;
    }
}

function CheckAll() {
    if (CheckUsername() && CheckPassword() && CheckRePassword()) {
        //document.getElementById("signup").disabled = false;
        document.getElementById('signup').style.cursor = "pointer";
    } else {
        //document.getElementById("signup").disabled = true;
        document.getElementById('signup').style.cursor = "not-allowed";
    }
}