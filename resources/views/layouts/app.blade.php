<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('pageDescription')">
    <link rel="shortcut icon" href="{{{ asset('img/icon.png') }}}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('pageTitle')</title>

    <!-- Scripts -->
    <script src="{!! asset('js/jquery/jquery-3.3.1.min.js') !!}"></script>

    <script>
    var img_remote_path='{{ config('app.img_remote_path') }}';
    </script>

    <!-- Bootsrap from Laravel app.css / app.js -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts - Prefetch Google Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">

    <!-- FontAwesome -->
    <link href="{{ asset('vendor/font-awesome/css/font-awesome.min.css') }}" id="font-awesome" rel="stylesheet">

    <!-- Styles - Local styles -->
    <link href="{{ asset('css/admin/style.css') }}" rel="stylesheet">
</head>

<body class="@yield('pageClass')">
    <div id="app">
      <header>
        @include('partials.menu')
      </header>


      <main id="main-content" class="container pt-5">
        @if (session('info'))
        <div class="alert alert-success">
            {{ session('info') }}
        </div>
        @endif
          @yield('content')
      </main>
      <footer>
        <div id="copyright">
          &copy;@php echo date("Y"); @endphp Mark Arenz
        </div>
      </footer>
    </div>
    <div id="app-modal" style="z-index:999;">
      <a href="#" class="close" onclick="$('#app-modal').hide(); return false;"><i class="fa fa-close"></i></a>
      <div class="stage">
        <div class="inner">
        </div>
      </div>
    </div>
    <script src="{{ asset('/js/admin.js') }}" defer></script>
    <!-- DATEPICKER -->
    <script src="{{ asset('/js/mms_datepicker/mms_datepicker.js') }}" defer></script>
    <link href="{{ asset('/js/mms_datepicker/mms_datepicker.css') }}" rel="stylesheet">
</body>
</html>
