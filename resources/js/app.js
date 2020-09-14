require('./bootstrap');
var $ = require('jquery');
require('jquery-validation');
require('jquery-validation/dist/additional-methods.js');
require('jquery-validation/dist/localization/messages_it.js');
import 'bootstrap';
var Chart = require('chart.js');
var moment = require('moment'); // require




$(document).ready(function() {

    //setto la libreria moment in italiano
    moment.locale("it");

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
                    minlength: 30
                }



            },
            errorPlacement: function (error, element) {
            //error.insertBefore(element);
            error.insertAfter(element.closest('.form-group'));
        },
        })
    })

    //Sezione Statistiche
    if($('#stats-show').length != 0) {
      stats('messages', 'chart-message', 'messaggi');
      stats('views', 'chart-views', 'visualizzazioni');
    }

    //se all'apertura della pagina c'e testo nell'input effettuo la conversione in coordinate
    if ($('#search').val() != '') {
        geocodeGuest()
    }

    // intercetto la pressione del pulsante sulla barra di ricerca
    $("#search").keyup(function() {
        if ($('#search').val() != '' && $('#search').val().length % 5) {
            geocodeGuest()
        }
    })

    function geocodeGuest() {
        var address = $('#search').val();

        geocodeGuestAjax(address);
    }

    function geocodeGuestAjax(address) {
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
                $("#search-button").click(function() {
                    if($("#search-error").length == 0) {
                        //se c'e un errore spossesso il button delle sue funzione
                        event.preventDefault();
                        //aggiungo un messagigo in pagina
                        $(".form-group").after("<label id=search-error class=error for=search>Inserisci un indirizzo valido</label>");
                    }
                })
            }
        })
    }



    //Inserisco un messaggio in caso in cui non ci siano appartamenti in evidenza
    if($('.in-evidenza a').length == 0) {
      $('.in-evidenza h1').after('<p class="text-center w-100">Nessuna sponsorizzazione presente</p>');
    }

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

    //se in pagina è presente il messaggio dell'esito sponsorizzazione, lo rimuovo dopo due secondi
    if ($(".info-sponsorship").length == 1) {
        setTimeout(function() {
            $(".info-sponsorship").toggleClass("active");
        },2000)
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
            }else {
              $('#view-length').text(data.length)
            }

            var months = {};
            for (var i = 1; i <= 12; i++) {
              //converto la i in mese testuale
              var data_moment = moment(i , "M").format("MMM");
              var data_moment_upp = data_moment.charAt(0).toUpperCase() + data_moment.slice(1);
              months[data_moment_upp] = 0;
            }

              if (data.results != 0) {
                for (var i = 0; i < data.results.length; i++) {
                var current_month = data.results[i].created_at;
                var moment_current_month = moment(current_month, "YYYY/MM/DD").format("MMM");
                var moment_current_month_upp = moment_current_month.charAt(0).toUpperCase() + moment_current_month.slice(1);
                months[moment_current_month_upp] ++;
                }
              }
              // console.log(months);
            var key_months = Object.keys(months);
            var value_months = Object.values(months);
            // console.log(key_months);
            // console.log(value_months);

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
