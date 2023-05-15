'use strict';

// import Request from './Request.js';

class Error 
{
    constructor(message, id) {
       
        this.message = message;
        this.id = id;
        this.showSpan();
    }
    
    showSpan()
    {
        let span = document.createElement("span");
        span.classList.add("form-error", "radicalError");
        span.textContent = this.message;
        document.getElementById(this.id).after(span);
        
    }
}

export default Error;