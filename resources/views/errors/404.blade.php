<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ops! Non found</title>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body id="error">
        @include('partials.header')
        <main>
            <div class="container-fluid">
                <div class="row">
                    <div class=" text col-12 col-md-6 d-flex align-items-center flex-column justify-content-around">
                        <h1 class="mb-3">Ops!</h1>
                        <p class="mt-3">Non troviamo la pagina che stai cercando.</p>
                        <a href="{{route("home")}}">Torna alla home</a>
                    </div>
                    <div class="col-12 col-md-6 d-flex justify-content-center">
                        <img src="{{asset("img/404.gif")}}" alt="Gif">
                    </div>
                </div>
            </div>
            <script src="{{ asset('js/app.js') }}" defer></script>
        </main>
    </body>
</html>
