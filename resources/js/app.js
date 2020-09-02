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
    })

    //invoco la funzione per mostrare l'indirizzo nell'index all'interno della back-offcie
    show_address(".box" , "#address", "#address span");
    //invoco la funzione per mostrare l'indirizzo nella show all'interno della back-office
    show_address("#show-info", "#address" ,"#address span");

    //funzione per il recupero della lan e lot
    function show_address(container, coordinates, item) {
        $(container).each(function() {
            var lon = $(this).find(coordinates).data("lon");
            var lat = $(this).find(coordinates).data("lat");
            var id = $(this).data("id");
            converti_indirizzo(lat,lon,id,container, item);
        })
    }

    //funzione per la conversione delle coordinate in indirizzo testuale
    function converti_indirizzo(lat,lon,id,container,item) {
        var query = lat + "," + lon;
        $.ajax({
            "url": "https://api.tomtom.com/search/2/reverseGeocode/" + query + ".json",
            "method": "GET",
            "data": {
                'key': 'VQnRG5CX322Qq4G6tKnUMDqG6DDv0Q6A'
            },
            "success": function(data) {
                var indirizzo_completo = data.addresses[0].address.freeformAddress;
                console.log(indirizzo_completo);
                $(container + "[data-id='" + id + "']").find(item).text(indirizzo_completo);
            },
            "error": function() {
                alert("Si è verificato un errore");
            }
        })
    }

})
