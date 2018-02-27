<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Helpdesk</title>

    <!-- Styles -->
    <link rel="icon" type="favicon.ico" href="/storage/images/favicon.ico" />
    <link rel="stylesheet" href="/css/app.css">
    <script
    src="https://code.jquery.com/jquery-1.12.4.js"
    integrity="sha256-Qw82+bXyGq6MydymqBxNPYTaUXXq7c8v3CwiYwLLNXU="
    crossorigin="anonymous"></script>
    <script type="text/javascript" src="/js/app.js"></script>
</head>
<body>
    <div id="app">
        @include('inc.navbar')
        <div class="container">
          @if(Request::is('setting/*'))
            @include('settings.dimmer')
          @endif
          @include('inc.messages')
          @yield('content')
      </div>
    </div>
    <footer id="footer" class="text-center">
      <div class="container">
    			<div class="row">
            <div class="col-md-12">
      <p>&copy; 2018 Helpdesk</p>
            </div>
          </div>
      </div>
    </footer>
</body>
</html>
