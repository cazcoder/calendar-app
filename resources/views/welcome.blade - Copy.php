<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="apple-touch-icon" sizes="76x76" href="/src/assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="/src/assets/img/favicon.png" />
    <title>Demo App</title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Nucleo Icons -->
    <link href="{{ asset('css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Main Styling -->
    <link href="{{ asset('css/soft-ui-dashboard-tailwind.css?v=1.0.5') }} rel="stylesheet" />

    @vite('resources/css/app.css')

    <script>

      (function () {
        window.User = {!! json_encode(optional(auth()->user())->only('id', 'name')) !!}

      })();
    
    </script>
  </head>

  <body class="m-0 font-sans text-base antialiased font-normal leading-default bg-gray-50 text-slate-500">
    <div id="app"></div>
    
    <script src="{{ asset('js/soft-ui-dashboard-tailwind.js?v=1.0.5') }} async></script>
    @vite('resources/js/app.js')
  </body>
</html>