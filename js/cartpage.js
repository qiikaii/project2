/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

document.getElementById('cartitemid').addEventListener('input', validateCartID);
document.getElementById('cartquantity').addEventListener('input', validateCartQty);

function validateCartID(event){
    var cartitemid = document.getElementById('cartitemid');
    var r = /^[0-9]{1,2}$/;
    cartitemid.setCustomValidity('');
    if (cartitemid.value === "") {
        cartitemid.setCustomValidity("Item can't be blank.");
        cartitemid.reportValidity();
        event.preventDefault();
        return false;
    }
    else if (r.test(cartitemid.value) === false){
        cartitemid.setCustomValidity('Need a valid item.');
        cartitemid.reportValidity();
        event.preventDefault(); 
        return false;
    }
    else if (r.test(cartitemid.value) === true){
        return true;
    }
}

function validateCartQty(event){
    var cartquantity = document.getElementById('cartquantity');
    var r = /^[0-9]{1,2}$/;
    cartquantity.setCustomValidity('');
    if (cartquantity.value === "") {
        cartquantity.setCustomValidity("Item quantity can't be blank.");
        cartquantity.reportValidity();
        event.preventDefault();
        return false;
    }
    else if (r.test(cartquantity.value) === false){
        cartquantity.setCustomValidity('Please enter a valid quantity number.');
        cartquantity.reportValidity();
        event.preventDefault(); 
        return false;
    }
    else if (r.test(cartquantity.value) === true){
        return true;
    }
}