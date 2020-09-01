require('./bootstrap');
var $ = require('jquery');
require('jquery-validation');
require('jquery-validation/dist/additional-methods.js');
require('jquery-validation/dist/localization/messages_it.js');
import 'bootstrap';

jQuery.validator.addMethod("lettersonly", function(value, element) {
    return this.optional(element) || /^[a-zA-Z\s]*$/.test(value);
}, "Inserisci solo lettere");

$('form').validate({ // initialize the plugin
    rules: {

        email: {
            required: true,
            email: true
        },

        password: {
            required: true,
            minlength: 8
        },

        name: {
            lettersonly: true,
        },

        lastname: {
            lettersonly: true
        },

        date_of_birth: {
            date: true
        },

    }
});

$(document).ready(function() {
    //intercetto il click sull hamburger del back-office e lo visualizzo o viceversa
    $("#aside-toggle").click(function() {
        $("aside").toggleClass("active");
        $(".nav-container").toggleClass("active");
    })
})
