<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-100">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
    <title>Demo App</title>
    <!--     Fonts    -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />

    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    
    <!-- Main Styling -->
    <link href="{{ asset('css/soft-ui-dashboard-tailwind.css?v=1.0.5') }} rel="stylesheet" />
    <link href="{{ asset('css/tooltip.css') }} rel="stylesheet" />

    @vite('resources/css/app.css')

    <script>

      (function () {
        window.User = {!! json_encode(optional(auth()->user())->only('id', 'name', 'email')) !!}
      })();
    
    </script>
  </head>

  <body class="h-full">
    <div id="app"></div>
    @vite('resources/js/app.js')
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/tippy.js@6"></script>
    <script>
    /*var execute = function () {
      console.log(document.querySelectorAll('[data-tippy-content]'));
      tippy('[data-tippy-content]');
    };*/

    window.onload = function() { // can also use window.addEventListener('load', (event) => {
    console.log(document.querySelectorAll('.countryFlag')); alert('testing');
    tippy('[data-tippy-content]');
    
  };


    </script>
  </body>
</html>