/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function validateName(name){
    var r=/[A-Za-z]{3,50}/;
    
    if (name === "") {
        alert("Name can't be blank.");
    }
        
    else if (r.test(name.value) === false){
        name.setCustomValidity('Name can only contain letters, at least 3 characters long and not mroe than 50 characters');
    }
    else if (r.test(name.value) === true){
        return true;
    }
}

function validateEmail(email){
    var r = new RegExp(/[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/);
    
    if (email === "") {
        alert("Email can't be blank.");
    }
    else if (r.test(email.value) === false){
        alert('Please enter a valid email address.');
    }
    else if (r.test(email.value) === true){
        return true;
    }
}

function validatePw(pw){
    var r=/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,15}$/;
    if (pw === "") {
        alert("Password can't be blank.");
    }
    else if (r.test(pw.value) === false){
        alert('Ensure password only have 1 uppercase, 1 lowercase, 1 number, 1 special character.');
    }
    else if (r.test(pw.value) === true){
        return true;
    }
}





var loginemail = document.getElementById('loginemail').value;
    var loginpass = document.getElementById('loginpass').value;
function validateLogin(){
    alert("Hey");
    loginemail.addEventListener('input', validateEmail(loginemail));
    validateEmail(loginemail);
    validatePw(loginpass);
}
document.getElementById('loginbutton').addEventListener("click", validateLogin());
//
//document.getElementById('regibutton').addEventListener('input', validateRegister);
//document.getElementById('resetbutton').addEventListener('input', validateReset);
