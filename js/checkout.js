
document.getElementById('address').addEventListener('input', validateAddress);
document.getElementById('postal').addEventListener('input', validatePostal);

function validateAddress(event){
    var address = document.getElementById('address');
    var r=/(?=^[0-9A-Za-z]+\s?[0-9A-Za-z]+$).{3,}/;
    address.setCustomValidity('');
    if (address.value === "") {
        address.setCustomValidity("Address can't be blank.");
        address.reportValidity();
        event.preventDefault();
        return false;
    }
        
    else if (r.test(address.value) === false){
        address.setCustomValidity('Please enter a valid address.');
        address.reportValidity();
        event.preventDefault();
        return false;
    }
    else if (r.test(address.value) === true){
        return true;
    }
}

function validatePostal(event){
    var postal = document.getElementById('postal');
    var r = /^[0-9]{6}$/;
    postal.setCustomValidity('');
    if (postal.value === "") {
        postal.setCustomValidity("Postal code can't be blank.");
        postal.reportValidity();
        event.preventDefault();
        return false;
    }
    else if (r.test(postal.value) === false){
        postal.setCustomValidity('Please enter a valid postal code.');
        postal.reportValidity();
        event.preventDefault();
        return false;
    }
    else if (r.test(postal.value) === true){
        return true;
    }
}