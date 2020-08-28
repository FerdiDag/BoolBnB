require('./bootstrap');
var $ = require('jquery');
require('jquery-validation');
require('jquery-validation/dist/additional-methods.js');
require('jquery-validation/dist/localization/messages_it.js');
import 'bootstrap';



$('form').validate({ // initialize the plugin
    rules: {

        email: {
            required: true,
            email: true
        },

        password: {
            required: true,
        },

        name: {
            lettersonly: true
        },

        lastname: {
            lettersonly: true
        },

    }
});
