require('./bootstrap');
var $ = require('jquery');
require('jquery-validation');
require('jquery-validation/dist/additional-methods.js');
require('jquery-validation/dist/localization/messages_it.js');
import 'bootstrap';




$(document).ready(function() {

    //validazione form lato-client
    jQuery.validator.addMethod("lettersonly", function(value, element) {
        return this.optional(element) || /^[a-zA-Z\s]*$/.test(value);
    }, "Inserisci solo lettere");

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


    //intercetto il click sull'hamburger menù per visualizzare l'aside in mobile
    $("#aside-toggle").click(function() {
        $("aside").toggleClass("active");
    })

    //chiamo la funzione per visualizzare gli indirizzo nelle index
    reverseGeocode("#index", ".box", "#address");

    //chiamo la funzione per visualizzare gli indirizzo nelle show
    reverseGeocode("#show-header", "#show-info","#address");

    //intercetto il click sul button "aggiungi indirizzo"
    $("#add_address").click(function() {
        //chiamo la funzione per la gestione dell'aggiunta indirizzo in fase di aggiunta e modifica appartamento
        geocodeBackoffice();
    })

    //inserisco l'indirizzo in pagina in fase di modifica dell'appartamento
    if ($(".container").is("#edit")) {
        //recuper i valori della lot e lan
        var lat = $("#add_lat").val();
        var lon = $("#add_lon").val();
        var query = lat + "," + lon;

        //effettuo la chiamata ajax
        $.ajax({
            "url": "https://api.tomtom.com/search/2/reverseGeocode/" + query + ".json",
            "method": "GET",
            "data": {
                'key': 'VQnRG5CX322Qq4G6tKnUMDqG6DDv0Q6A'
            },
            "success": function(data) {
                //recupero l'indirizzo testuale dalla risposta
                var address = data.addresses[0].address.freeformAddress;
                //inserisco l'indirizzo in pagina
                $("#address").val(address);
            },
            "error": function() {
                alert("Si è verificato un errore");
            }
        })
    }

    $("#send_form").click(function() {
        if ($("#add_lat").val() == "" || $("#add_lon").val() == "") {
            event.preventDefault();
            $("#status_load").text("Inserisci un indirizzo valido e clicca su 'Aggiungi' per proseguire");
        }
    })


    //**************FUNZIONI*************//
    //**********************************//

    //funzione per la conversione dell'indirizzo da testuale a coordinate
    function geocodeBackoffice() {
        if ($("#address").val().length > 0) {
            //recupero il valore dell'input indirizzo
            var address = $("#address").val();
            //effettuo la chiamata ajax tramite la funzione apposita
            geocodeBackofficeAjax(address);
        } else {
            $("#status_load").text("Digita un indirizzo per proseguire");
        }
    }

    //funzione per la chiamata ajax verso le Api geocode di tomtom
    function geocodeBackofficeAjax(address) {
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
    }

    //creo una funzione per mostrare l'indirizzo in pagina partendo dalle coordinate
    function reverseGeocode(section,container,tag_indirizzo) {
        if ($(section).length == 1) {
            $(container).each(function() {
                var indirizzo = $(this).find(tag_indirizzo);
                var id = $(this).data("id");
                var lat = indirizzo.data("lat");
                var lon = indirizzo.data("lon");
                var query = lat + "," + lon;
                ajax_reverse_geocode(id,query,container);
            })
        }
    }

    //creo una funzione che esegua una chiamata ajax all'API TomTom
    function ajax_reverse_geocode(id,query,container) {
        $.ajax({
            "url": "https://api.tomtom.com/search/2/reverseGeocode/" + query + ".json",
            "method": "GET",
            "data": {
                'key': 'VQnRG5CX322Qq4G6tKnUMDqG6DDv0Q6A'
            },
            "success": function(data) {
                //recupero l'indirizzo testuale dall'Api
                var indirizzo_testuale = data.addresses[0].address.freeformAddress;
                //lo inserisco in pagina
                $(container + "[data-id='" + id + "']").find("#address span").text(indirizzo_testuale);
            },
            "error": function() {
                alert("Si è verificato un errore");
            }
        })
    }
})
