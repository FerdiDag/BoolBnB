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

        description_title: {
            required: true,
            minlength: 255
        },

        description: {
            minlength: 50
        },

        cover_image: {
            file: true,
            image: true
        }



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
                $(container + "[data-id='" + id + "']").find(item).text(indirizzo_completo);
            },
            "error": function() {
                alert("Si è verificato un errore");
            }
        })
    }

    //intercetto il click sul button "aggiungi indirizzo"
    $("#add_address").click(function() {
        //recupero il valore dell'input indirizzo
        var address = $("#address").val();
        //effettuo la chiamata ajax per convertire l'indirizzo testuale in coordinate
        $.ajax({
            "url": "https://api.tomtom.com/search/2/geocode/" + address + ".json",
            "method": "GET",
            "data": {
                'key': 'VQnRG5CX322Qq4G6tKnUMDqG6DDv0Q6A',
                "limit": 1
            },
            "success": function(data) {
                var result = data.results;
                console.log(lat);
                console.log(lon);
                if (result.length > 0) {
                    var lat = result[0].position.lat;
                    var lon = result[0].position.lon;
                    //recuper l'input nascosto predisposto per la lat
                    $("#add_lat").val(lat);
                    $("#add_lon").val(lon);
                }
                console.log(result);

            },
            "error": function() {
                alert("Si è verificato un errore");
            }
        })
    })
})
