require('./bootstrap');
var $ = require('jquery');
require('jquery-validation');
require('jquery-validation/dist/additional-methods.js');
require('jquery-validation/dist/localization/messages_it.js');
import 'bootstrap';

jQuery.validator.addMethod("lettersonly", function(value, element) {
    return this.optional(element) || /^[a-zA-Z\s]*$/.test(value);
}, "Inserisci solo lettere");



$(document).ready(function() {

    $('form').each(function() {  // selects all forms with class="form"
        $(this).validate({
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
                    maxlength: 255
                },

                description: {
                    minlength: 50
                },

                address: {
                    required: true
                },

                number_of_rooms: {
                    required: true,
                    rangelength: [1,11],
                    min: 1
                },

                number_of_beds: {
                    required: true,
                    rangelength: [1,11],
                    min: 1
                },

                number_of_bathrooms: {
                    required: true,
                    rangelength: [1,11],
                    min: 1
                },

                square_meters: {
                    required: true,
                    rangelength: [1,11],
                    min: 1
                },

                "services[]": {
                    required: true
                }
            },
            errorPlacement: function (error, element) {
            //error.insertBefore(element);
            error.insertAfter(element.closest('.form-group'));
        },
        })
    })

    //intercetto il click sull hamburger del back-office e lo visualizzo o viceversa
    $("#aside-toggle").click(function() {
        $("aside").toggleClass("active");
    })

    //invoco la funzione per mostrare l'indirizzo nell'index all'interno della back-offcie
    if ($(".container").is("#index")) {
        show_address(".box" , "#address", "#address span");
    }

    //invoco la funzione per mostrare l'indirizzo nella show all'interno della back-office
    if ($(".container").is("#show-header")) {
        show_address("#show-info", "#address" ,"#address span");
    }

    //inserisco l'indirizzo in pagina in fase di modifica dell'appartamento
    if ($(".container").is("#edit")) {
        //recuper i valori della lot e lan
        var lat = $("#add_lat").val();
        var lon = $("#add_lon").val();
        var query = lat + "," + lon;

        $.ajax({
            "url": "https://api.tomtom.com/search/2/reverseGeocode/" + query + ".json",
            "method": "GET",
            "data": {
                'key': 'VQnRG5CX322Qq4G6tKnUMDqG6DDv0Q6A'
            },
            "success": function(data) {
                var address = data.addresses[0].address.freeformAddress;
                //inserisco l'indirizzo in pagina
                $("#address").val(address);
            },
            "error": function() {
                alert("Si è verificato un errore");
            }
        })
    }

    //intercetto il click sul button "aggiungi indirizzo"
    $("#add_address").click(function() {
        if ($("#address").val().length > 0) {
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
                    if (result.length > 0) {
                        var lat = result[0].position.lat;
                        var lon = result[0].position.lon;
                        //recuper l'input nascosto predisposto per la lat
                        $("#add_lat").val(lat);
                        $("#add_lon").val(lon);
                        $("#status_load").text("Indirizzo aggiunto correttamente!")
                    } else {
                        $("#status_load").text("Inserisci un indirizzo valido");
                    }
                },
                "error": function() {
                    alert("Si è verificato un errore");
                }
            })
        } else {
            $("#status_load").text("Digita un indirizzo per proseguire");
        }
    })

    $("#send_form").click(function() {
        if ($("#add_lat").val() == "" || $("#add_lon").val() == "") {
            event.preventDefault();
            $("#status_load").text("Inserisci un indirizzo valido e clicca su 'Aggiungi' per proseguire");
        }
    })

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
})
