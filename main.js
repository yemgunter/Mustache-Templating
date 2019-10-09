/***********************************************************
 * Name: Yolanda Gunter
 * Assignment: Coding 05
 * Purpose: Templating & Making a 3+ Page Website
 * Notes: Learning then implementing Mustache to create templates.
 **********************************************************************/

"use strict";

function clearForm() {
    /*
    * these are my form elements. this function replaces text in text boxes with empty strings and replaces the message area with an html <br>
    */
    document.getElementById("name").value = "";
    document.getElementById("email").value = "";
    document.getElementById("email2").value = "";
    document.getElementById("subject").value = "";
    document.getElementById("message").value = "";
    document.getElementById("msg").innerHTML = "<br>";
}

function validEmail(email) {
    /* do not modify this fucntion, just use it as is */
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function validate() {
    var errorMessage = "";
    
    //all the elements into the function
    var nameInput = document.getElementById("name");
    var emailInput = document.getElementById("email");
    var email2Input = document.getElementById("email2");
    var subjectInput = document.getElementById("subject");
    var messgeInput = document.getElementById("message");
    
    //all the strings in the elements trimmed
    var name = nameInput.value.trim();
    var email = emailInput.value.trim();
    var email2 = email2Input.value.trim();
    var subject = subjectInput.value.trim();
    var message = messgeInput.value.trim();
    
    //trimmed versions back into form for good UX
    nameInput.value = name;
    emailInput.value = email;
    email2Input.value = email2;
    subjectInput.value = subject;
    messgeInput.value = message;
    
    //test strings from form and store errors
    if (name === "") {
        errorMessage += "Name cannot be empty.<br>";
    }
    
    if (email === "") {
        errorMessage += "First email is not valid.<br>";
    }
    
    if (email2 === "") {
        errorMessage += "Second email is not valid.<br>";
    }
    
    if (email2 !== email) {
        errorMessage += "Emails must match.<br>";
    }
    
    if (subject === "") {
        errorMessage += "Subject cannot be empty.<br>";
    }
    
    if (message === "") {
        errorMessage += "Message cannot be empty.<br>";
    }
    //send errors back or send empty string if no error
    return errorMessage;
    
}

//get button into a JS object
var sendBtn = document.getElementById("contact-send");
//event listener and handler for send button
sendBtn.onclick = function () {
    //bring message area in to report errors
    var msgArea = document.getElementById("msg");
    //get validation of form
    var msg = validate();
    //report errors or submit form
    if (msg === "") {
        document.forms["contact-form"].submit();
    } else {
        msgArea.innerHTML = msg;
    }
};

//get the button into a JS object
var clearBtn = document.getElementById("contact-clear");
//create an event listener and handler for the clear button
clearBtn.onclick = function () {
    //call clear if the button is pressed
    clearForm();
};
