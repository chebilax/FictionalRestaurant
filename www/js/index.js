'use strict';

import Request from './modules/Request.js';

let btnSubmit;


function validForm(event)
{
    $('span').empty()
    $('span').removeClass('form-error', 'radicalError');
    
    let inputs = document.querySelectorAll('input');
    
    let request = new Request();
    request.getInputs(inputs);
    
    if(request.firstName == "" || request.lastName == "" || request.birthDate == "" || request.email == "" || request.password == "" || request.adress == "" || request.city == "" || request.postalCode == "" || request.country == "" || request.phone == "")
    {
        event.preventDefault();
    }
    
}


document.addEventListener("DOMContentLoaded",function(){
    
    btnSubmit = document.getElementById("submit");
    
    btnSubmit.addEventListener('click',validForm);
    
})