/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

document.getElementById('loginemail').addEventListener('input', validateLoginEmail);
document.getElementById('loginpass').addEventListener('input', validateLoginPw);

function validateLoginEmail(event){
    var loginemail = document.getElementById('loginemail');
    var r = /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/;
    loginemail.setCustomValidity('');
    if (loginemail.value === "") {
        loginemail.setCustomValidity("Email can't be blank.");
        loginemail.reportValidity();
        event.preventDefault();
        return false;
    }
    else if (r.test(loginemail.value) === false){
        loginemail.setCustomValidity('Please enter a valid email address.');
        loginemail.reportValidity();
        event.preventDefault(); 
        return false;
    }
    else if (r.test(loginemail.value) === true){
        return true;
    }
}

function validateLoginPw(event){
    var loginpw = document.getElementById('loginpass');
    var r=/(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}/;
    loginpw.setCustomValidity('');    
    if (loginpw.value === "") {
        loginpw.setCustomValidity("Password can't be blank.");
        loginpw.reportValidity();
        event.preventDefault();
        return false;
    }
    else if (r.test(loginpw.value) === false){
        loginpw.setCustomValidity('Must contain at least 8 characters with 1 uppercase, 1 lowercase and 1 number/special character." ');
        loginpw.reportValidity();
        event.preventDefault();   
        return false;
    }
    else if (r.test(loginpw.value) === true){
        return true;
    }
}

document.getElementById('reginame').addEventListener('input', validateRegiName);
document.getElementById('regiemail').addEventListener('input', validateRegiEmail);
document.getElementById('regipass').addEventListener('input', validateRegiPass);
document.getElementById('regiconpass').addEventListener('input', validateRegiConPass);


function validateRegiName(event){
    var reginame = document.getElementById('reginame');
    var r=/^[a-zA-Z]+( [a-zA-Z]+)*$/;
    reginame.setCustomValidity('');
    if (reginame.value === "") {
        reginame.setCustomValidity("Name can't be blank.");
        reginame.reportValidity();
        event.preventDefault();
        return false;
    }
        
    else if (r.test(reginame.value) === false){
        reginame.setCustomValidity('Name can only contain letters, at least 3 characters long');
        reginame.reportValidity();
        event.preventDefault();
        return false;
    }
    else if (r.test(reginame.value) === true){
        return true;
    }
}

function validateRegiEmail(event){
    var regiemail = document.getElementById('regiemail');
    var r = /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/;
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
    var regipwd = document.getElementById('regipass');
    var r = /(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}/;
    regipwd.setCustomValidity('');
    if (regipwd.value === "") {
        regipwd.setCustomValidity("Password can't be blank.");
        regipwd.reportValidity();
        event.preventDefault();
        return false;
    }
    else if (r.test(regipwd.value) === false){
        regipwd.setCustomValidity('Password must contain at least 8 characters with 1 uppercase, 1 lowercase and 1 number/special character.');
        regipwd.reportValidity();
        event.preventDefault();
        return false;
    }
    else if (r.test(regipwd.value) === true){
        return true;
    }
}

function validateRegiConPass(event){
    var regipwd = document.getElementById('regipass');
    var cpwd = document.getElementById('regiconpass');
    var r = /(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}/;
    cpwd.setCustomValidity('');
    if (cpwd.value === "") {
        cpwd.setCustomValidity("Confirm Password can't be blank.");
        cpwd.reportValidity();
        event.preventDefault();
        return false;
    }
    else if (r.test(cpwd.value) === false){
        cpwd.setCustomValidity('Confirm Password must contain at least 8 characters with 1 uppercase, 1 lowercase and 1 number/special character.');
        cpwd.reportValidity();
        event.preventDefault();
        return false;
    }
    else if (cpwd.value !== regipwd.value) {
        cpwd.setCustomValidity('Confirm Password must match Password above.');
        cpwd.reportValidity();
        event.preventDefault();
        return false;
    }
    
    else if (r.test(cpwd.value) === true){
        return true;
    }
}

document.getElementById('resetname').addEventListener('input', validateResetName);
document.getElementById('resetemail').addEventListener('input', validateResetEmail);

function validateResetName(event){
    var resetname = document.getElementById('resetname');
    var r=/^[a-zA-Z]+( [a-zA-Z]+)*$/;
    resetname.setCustomValidity('');
    if (resetname.value === "") {
        resetname.setCustomValidity("Name can't be blank.");
        resetname.reportValidity();
        event.preventDefault();
        return false;
    }
        
    else if (r.test(resetname.value) === false){
        resetname.setCustomValidity('Name can only contain letters, at least 3 characters long');
        resetname.reportValidity();
        event.preventDefault();
        return false;
    }
    else if (r.test(resetname.value) === true){
        return true;
    }
}

function validateResetEmail(event){
    var resetemail = document.getElementById('resetemail');
    var r = /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/;
    resetemail.setCustomValidity('');
    if (resetemail.value === "") {
        resetemail.setCustomValidity("Email can't be blank.");
        resetemail.reportValidity();
        event.preventDefault();
        return false;
    }
    else if (r.test(resetemail.value) === false){
        resetemail.setCustomValidity('Please enter a valid email address.');
        resetemail.reportValidity();
        event.preventDefault();
        return false;
    }
    else if (r.test(resetemail.value) === true){
        return true;
    }
}