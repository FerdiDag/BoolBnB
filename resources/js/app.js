require('./bootstrap');
//import j query
var $ = require('jquery');
//import j-query validation
require('jquery-validation');
require('jquery-validation/dist/additional-methods.js');
require('jquery-validation/dist/localization/messages_it.js');
//import bootstrap
import 'bootstrap';
//import chart-js
var Chart = require('chart.js');
//import moment.js
var moment = require('moment');
//import handlebars
const Handlebars = require("handlebars");
//Import Algolia search-box
var places = require('places.js');

if ($('.algolia').length != 0) {
  const options = {
    appId: 'plJM0BX61QPS',
    apiKey: '0482cdf528ff1627a104a659c03b6bc8',
    container: '.algolia',
    language: 'it',
  };
  places(options);
};


$(document).ready(function() {

    //validazione form lato-client
    jQuery.validator.addMethod("lettersonly", function(value, element) {
        return this.optional(element) || /^[a-zA-Z\s]*$/.test(value);
    }, "Inserisci solo lettere");

    //ciclo i form per validarli lato client con il supporto di j-query validation
    $('form').each(function() { // selects all forms with class="form"
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
                    rangelength: [1, 11],
                    min: 1
                },

                number_of_beds: {
                    required: true,
                    rangelength: [1, 11],
                    min: 1
                },

                number_of_bathrooms: {
                    required: true,
                    rangelength: [1, 11],
                    min: 1
                },

                square_meters: {
                    required: true,
                    rangelength: [1, 11],
                    min: 1
                },

                "services[]": {
                    required: true
                },

                type: {
                    required: true
                },

                search: {
                    required: true
                },

                lan: {
                    required: true
                },

                lot: {
                    required: true
                },

                text: {
                    required: true,
                    minlength: 15
                }



            },
            errorPlacement: function(error, element) {
                //error.insertBefore(element);
                error.insertAfter(element.closest('.form-group'));
            },
        })
    })

    //creo una variabile con all'interno la chiave tomtom
    var key = "WnguCpNi1nmX08ODcn2NVwLLG8LD75Wd";

    //Imposto autocompletamento ricerca
    $('.ap-dataset-places').on('click', function() {
        setTimeout(function(){
          geocodeGuest();
        }, 100)
    })

    //Imposto autocompletamento ricerca al premere di invio
    $('#search').keyup(function() {
        if (event.which == 13) {
            setTimeout(function(){
              geocodeGuest();
            }, 100)
        }
    })

    //se sono nella ricerca avanzata compilo le funzioni di handlebars
    if ($("#advanced-search").length > 0) {
        //funzioni per handlebars
        var source   = $("#apartment-box").html();
        var template = Handlebars.compile(source);
    }

    //intercetto il click sul tasto "cerca"
    $("#search-button").click(function() {
        advanced_search();
    })

    //Sezione Statistiche
    if ($('#stats-show').length != 0) {
        stats('messages', 'chart-message', 'messaggi');
        stats('views', 'chart-views', 'visualizzazioni');
    }

    //se all'apertura della pagina c'e testo nell'input effettuo la conversione in coordinate
    if ($('#search').val() != '') {
        geocodeGuest()
    }

    // intercetto la pressione del pulsante sulla barra di ricerca
    $("#search").keyup(function() {
        if ($('#search').val() != '' && $('#search').val().length % 3 == 0)  {
            console.log($('#search').val().length % 5);
            geocodeGuest()
        }
    })

    //intercetto il click sull'hamburger menù per visualizzare l'aside in mobile
    $("#aside-toggle").click(function() {
        $("aside").toggleClass("active");
    })

    //chiamo la funzione per visualizzare gli indirizzo nelle index
    reverseGeocode("#index", ".box", "#address");

    //chiamo la funzione per visualizzare gli indirizzo nelle show
    reverseGeocode("#show-header", "#show-info", "#address");

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
                'key': key
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

    //se in pagina è presente il messaggio dell'esito sponsorizzazione, lo rimuovo dopo due secondi
    if ($(".info-sponsorship").length == 1) {
        setTimeout(function() {
            $(".info-sponsorship").toggleClass("active");
        }, 2000)
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
                'key': key,
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
            }
        })
    }

    //creo una funzione per mostrare l'indirizzo in pagina partendo dalle coordinate
    function reverseGeocode(section, container, tag_indirizzo) {
        if ($(section).length == 1) {
            $(container).each(function() {
                var indirizzo = $(this).find(tag_indirizzo);
                var id = $(this).data("id");
                var lat = indirizzo.data("lat");
                var lon = indirizzo.data("lon");
                var query = lat + "," + lon;
                ajax_reverse_geocode(id, query, container);
            })
        }
    }

    //creo una funzione che esegua una chiamata ajax all'API TomTom
    function ajax_reverse_geocode(id, query, container) {
        $.ajax({
            "url": "https://api.tomtom.com/search/2/reverseGeocode/" + query + ".json",
            "method": "GET",
            "data": {
                'key': key
            },
            "success": function(data) {
                //recupero l'indirizzo testuale dall'Api
                var indirizzo_testuale = data.addresses[0].address.freeformAddress;
                //lo inserisco in pagina
                $(container + "[data-id='" + id + "']").find("#address span").text(indirizzo_testuale);
            },
            "error": function() {
            }
        })
    }

    //funzione per la conversione dell'indirizzo in coordinate
    function geocodeGuest() {
        var address = $('#search').val();

        geocodeGuestAjax(address);
    }

    //funzione per la chimata ajax alle api di tomtom per convertire gli indirizzi in coordinate
    function geocodeGuestAjax(address) {
        $.ajax({
            "url": "https://api.tomtom.com/search/2/geocode/" + address + ".json",
            "method": "GET",
            "data": {
                'key': key,
                "limit": 1
            },
            "success": function(data) {
                var result = data.results;
                if (result.length > 0) {
                    if ($("#search-error").length > 0) {
                        $(this).remove();
                    }
                    var lat = result[0].position.lat;
                    var lon = result[0].position.lon;
                    //recuper l'input nascosto predisposto per la lat
                    $("#add_lat").val(lat);
                    $("#add_lon").val(lon);
                }
            },
            "error": function() {
            }
        })
    }

    //funzione per la ricerca avanzata
    function advanced_search() {
        if ($("#advanced-search").length > 0) {
            if ($("#services-advanced-search:checked").length > 0 && $("#search").val().length > 0) {
                var lon = $("#add_lon").val();
                var lat = $("#add_lat").val();
                $(".error").remove();
                var number_of_rooms = $("#number_of_rooms").val();
                var number_of_beds = $("#number_of_beds").val();
                var km = $("#km").val();
                var array_service = [];
                var app_in_page = [];

                //effettuo un each per ottenere una stringa di servizi selezionati
                $("#services-advanced-search:checked").each(function() {
                     array_service.push($(this).closest("label").text().trim());
                })
                //trasormo l'array in una stringa per passarlo nel data dell'ajax
                var services = array_service.join(",");
                ajax_search(services,lon,lat,number_of_rooms,number_of_beds,km,app_in_page);


            } else {
                $(".error").remove();
                if ($(".error").length == 0) {
                    if ($("#services-advanced-search:checked").length == 0 && $("#search").val().length == 0) {
                        $(".number-services-box").after("<label id=search-error class='error' for=search>Devi selezionare almeno un servizio</label>");
                        $(".search-bar").after("<label id=search-error class='error' for=search>Devi digitare un indirizzo</label>");
                    }
                    else if ($("#services-advanced-search:checked").length == 0) {
                        $(".number-services-box").after("<label id=search-error class='error' for=search>Devi selezionare almeno un servizio</label>");
                    } else {
                        $(".search-bar").after("<label id=search-error class='error' for=search>Devi digitare un indirizzo</label>");
                    }
                }
            }
        }
    }

    //funzione per la chiamata ajax nella ricerca avanzata
    function ajax_search(services,lon,lat,number_of_rooms,number_of_beds,km,app_in_page) {
        //effettuo una chiamata ajax per recuperare eventuali appartamenti sponsorizzati
        $.ajax({
            "url": "http://localhost:8000/api/advanced/sponsorships",
            "method": "GET",
            "data": {
                'services': services,
                "lon": lon,
                "lat": lat,
                "number_of_rooms": number_of_rooms,
                "number_of_beds": number_of_beds,
                "range": km
            },
            "success": function(data) {
                //svuoto il contenuto della pagina
                $(".marked").html("");
                $(".normal").html("");
                $(".no-result").remove();
                // se i risultati sono maggiori di 0 inserisco gli appartamenti in pagina
                if (data.length > 0) {
                    //ciclo gli appartamenti
                    for (var i = 0; i < data.length; i++) {
                        //creo una variabile contenente l'appartamento corrente
                        var appartamento_corrente = data.results[i];
                        //inserisco l'id nell array per tenerne traccia
                        app_in_page.push(appartamento_corrente.apartment_id);
                        //creo l'oggetto da restituire ad handlebars
                        var context = {
                            "slug": appartamento_corrente.slug,
                            "id" : appartamento_corrente.apartment_id,
                            "image": appartamento_corrente.cover_image,
                            "title": appartamento_corrente.description_title,
                            "description" : appartamento_corrente.description,
                            "beds": appartamento_corrente.number_of_beds,
                            "rooms": appartamento_corrente.number_of_rooms,
                            "bathrooms": appartamento_corrente.number_of_bathrooms,
                            "square_meters":appartamento_corrente.square_meters,
                            "lon": appartamento_corrente.lon,
                            "lat": appartamento_corrente.lat
                        }
                        var html_finale = template(context);
                        $(".marked").append(html_finale);
                    }

                    //invoco la funzione per convertire gli indirizzi
                    reverseGeocode("#index", ".box", "#address");
                };
                //effettuo una chiamata ajax per recuperare eventuali appartamenti non sponsorizzati
                $.ajax({
                    "url": "http://localhost:8000/api/advanced/apartments",
                    "method": "GET",
                    "data": {
                        'services': services,
                        "lon": lon,
                        "lat": lat,
                        "number_of_rooms": number_of_rooms,
                        "number_of_beds": number_of_beds,
                        "range": km
                    },
                    "success": function(data) {
                        // se i risultati sono maggiori di 0 inserisco gli appartamenti in pagina
                        if (data.length > 0) {
                            //ciclo gli appartamenti
                            for (var i = 0; i < data.length; i++) {
                                //creo una variabile contenente l'appartamento corrente
                                var appartamento_corrente = data.results[i];
                                //verifico se l'appartamentoè già presente in pagina
                                if (!app_in_page.includes(appartamento_corrente.id)) {
                                    //inserisco l'id nell array per tenerne traccia
                                    app_in_page.push(appartamento_corrente.id);
                                    //creo l'oggetto da restituire ad handlebars
                                    var context = {
                                        "slug": appartamento_corrente.slug,
                                        "id" : appartamento_corrente.id,
                                        "image": appartamento_corrente.cover_image,
                                        "title": appartamento_corrente.description_title,
                                        "description" : appartamento_corrente.description,
                                        "beds": appartamento_corrente.number_of_beds,
                                        "rooms": appartamento_corrente.number_of_rooms,
                                        "bathrooms": appartamento_corrente.number_of_bathrooms,
                                        "square_meters":appartamento_corrente.square_meters,
                                        "lon": appartamento_corrente.lon,
                                        "lat": appartamento_corrente.lat
                                    }
                                    var html_finale = template(context);
                                    $(".normal").append(html_finale);
                                }
                            }
                            //invoco la funzione per convertire gli indirizzi
                            reverseGeocode("#index", ".box", "#address");
                        } else if($(".marked a").length == 0 && $(".normal a").length == 0) {
                            //se non sono presenti appartamenti in pagina inserisco un messaggio
                                $(".appartamenti .container").append("<h3 class='text-center no-result mt-3'>Nessun appartamento trovato</h3>");
                        }
                    },
                    "error": function() {
                    }
                })
            },
            "error": function() {
            }
        })
    }

    //funzione per recuperare i dati da inserire nei grafici
    function stats(type, container, info) {
        var id = $('#stats-show').data('id');
        var token = $('#stats-show').data('token');

        $.ajax({
            "url": "http://localhost:8000/api/stats/" + type,
            "method": "GET",
            "data": {
                'apartment_id': id,
                'api_token': token
            },
            "success": function(data) {
                if (container == 'chart-message') {
                    $('#message-length').text(data.length)
                } else {
                    $('#view-length').text(data.length)
                }

                var months = {};
                for (var i = 1; i <= 12; i++) {
                    //converto la i in mese testuale
                    var data_moment = moment(i, "M").format("MMM");
                    var data_moment_upp = data_moment.charAt(0).toUpperCase() + data_moment.slice(1);
                    months[data_moment_upp] = 0;
                }

                if (data.results != 0) {
                    for (var i = 0; i < data.results.length; i++) {
                        var current_month = data.results[i].created_at;
                        var moment_current_month = moment(current_month, "YYYY/MM/DD").format("MMM");
                        var moment_current_month_upp = moment_current_month.charAt(0).toUpperCase() + moment_current_month.slice(1);
                        months[moment_current_month_upp]++;
                    }
                }
                var key_months = Object.keys(months);
                var value_months = Object.values(months);

                var grafico_mesi = new Chart($('#' + container)[0].getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: key_months,
                        datasets: [{
                            data: value_months,
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            pointBackgroundColor: "green",
                            lineTension: 0.3
                        }]
                    },
                    options: {
                        title: {
                            display: true,
                            text: 'Numero di ' + info + ' per mese'
                        },
                        legend: {
                            display: false
                        },
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                },
                                gridLines: {
                                    display: false
                                }
                            }],
                            xAxes: [{
                                gridLines: {
                                    display: false
                                }
                            }]
                        }
                    }
                })

            },
            "error": function() {
                alert('errore');
            }
        });
    }
})
