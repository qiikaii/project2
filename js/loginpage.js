/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// Login Validation
document.getElementById('loginemail').addEventListener('input', validateEmail);
document.getElementById('loginpass').addEventListener('input', validatePw);

function validateEmail(event){
    var email = document.getElementById('loginemail');
    var r = /[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/;
    email.setCustomValidity('');
    if (email.value === "") {
        email.setCustomValidity("Email can't be blank.");
        email.reportValidity();
        event.preventDefault();
        return false;
    }
    else if (r.test(email.value) === false){
        email.setCustomValidity('Please enter a valid email address.');
        event.preventDefault();        
        email.reportValidity();
        return false;
    }
    else if (r.test(email.value) === true){
        return true;
    }
}

function validatePw(event){
    var pw = document.getElementById('loginpass');
    var r=/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,15}$/;
    pw.setCustomValidity('');    
    if (pw.value === "") {
        pw.setCustomValidity("Password can't be blank.");
        pw.reportValidity();
        event.preventDefault();
        return false;
    }
    else if (r.test(pw.value) === false){
        pw.setCustomValidity('Ensure password only have 1 uppercase, 1 lowercase, 1 number, 1 special character.');
        pw.reportValidity();
        event.preventDefault();   
        return false;
    }
    else if (r.test(pw.value) === true){
        return true;
    }
}

// Register Validation
// 
// 
// 
// 
// 
// 
// Register Validation not working for now. Only login validation. For further debugging!!!
//
//
//
//
//
//
document.getElementById('reginame').addEventListener('input', validateRegiName);
document.getElementById('regiemail').addEventListener('input', validateRegiEmail);
document.getElementById('regipass').addEventListener('input', validateRegiPass);
document.getElementById('regiconpass').addEventListener('input', validateRegiConPass);


function validateRegiName(event){
    var name = document.getElementById('reginame');
    var r=/(?=^[A-Za-z]+\s?[A-Za-z]+$).{3,30}/;
    name.setCustomValidity('');
    if (name.value === "") {
        name.setCustomValidity("Name can't be blank.");
        name.reportValidity();
        event.preventDefault();
        return false;
    }
        
    else if (r.test(name.value) === false){
        name.setCustomValidity('Name can only contain letters, at least 3 characters long and not mroe than 50 characters');
        name.reportValidity();
        event.preventDefault();
        return false;
    }
    else if (r.test(name.value) === true){
        return true;
    }
}

function validateRegiEmail(event){
    var regiemail = document.getElementById('regiemail');
    var r = /[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/;
    regiemail.setCustomValidity('');
    if (regiemail.value === "") {
        regiemail.setCustomValidity("Email can't be blank.");
        regiemail.reportValidity();
        event.preventDefault();
        return false;
    }
    else if (r.test(regiemail.value) === false){
        regiemail.setCustomValidity('Please enter a valid email address.');
        regiemail.reportValidity();
        event.preventDefault();
        return false;
    }
    else if (r.test(regiemail.value) === true){
        return true;
    }
}

function validateRegiPass(event){
    var pwd = document.getElementById('regipass');
    var r = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,15}$/;
    pwd.setCustomValidity('');
    if (pwd.value === "") {
        pwd.setCustomValidity("Password can't be blank.");
        pwd.reportValidity();
        event.preventDefault();
        return false;
    }
    else if (r.test(pwd.value) === false){
        pwd.setCustomValidity('Password does not match requirements');
        pwd.reportValidity();
        event.preventDefault();
        return false;
    }
    else if (r.test(pwd.value) === true){
        return true;
    }
}

function validateRegiConPass(event){
    var cpwd = document.getElementById('regiconpass');
    var r = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,15}$/;
    cpwd.setCustomValidity('');
    if (cpwd.value === "") {
        cpwd.setCustomValidity("Confirm Password can't be blank.");
        cpwd.reportValidity();
        event.preventDefault();
        return false;
    }
    else if (r.test(cpwd.value) === false){
        cpwd.setCustomValidity('Confirm Password does not match requirements');
        cpwd.reportValidity();
        event.preventDefault();
        return false;
    }
    else if (r.test(cpwd.value) === true){
        return true;
    }
}



//var loginemail = document.getElementById('loginemail').value;
//var loginpass = document.getElementById('loginpass').value;
//function validateLogin(){
//    alert("Hey");
//    loginemail.addEventListener('input', validateEmail(loginemail));
//    validateEmail(loginemail);
//    validatePw(loginpass);
//}
//document.getElementById('loginbutton').addEventListener("click", validateLogin());
//
//document.getElementById('regibutton').addEventListener('input', validateRegister);
//document.getElementById('resetbutton').addEventListener('input', validateReset);
