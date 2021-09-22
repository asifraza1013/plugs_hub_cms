<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Yolo Store') }}</title>
        <!-- Favicon -->
        <link href="{{ asset('argon') }}/img/brand/favicon.png" rel="icon" type="image/png">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
        <!-- Icons -->
        <link href="{{ asset('argon') }}/vendor/nucleo/css/nucleo.css" rel="stylesheet">
        <link href="{{ asset('argon') }}/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
        <!-- Argon CSS -->
        <link type="text/css" href="{{ asset('argon') }}/css/argon.css?v=1.0.0" rel="stylesheet">
        <!-- Argon CSS -->
        <link type="text/css" href="{{ asset('custom') }}/css/custom.css" rel="stylesheet">
        <!-- Select2 -->
        <!--<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />-->
        <link type="text/css" href="{{ asset('custom') }}/css/select2.min.css" rel="stylesheet">
        <!-- Jasny File Upload -->
        <!--<link type="text/css" href="{{ asset('fileupload') }}/fileupload.css" rel="stylesheet">-->
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/4.0.0/css/jasny-bootstrap.min.css">
        <!-- Flatpickr datepicker -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        @yield('head')
    </head>
    <body class="{{ $class ?? '' }}">
        @auth()
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            @include('layouts.navbars.sidebar')
        @endauth

        <div class="main-content">
            @include('layouts.navbars.navbar')
            @yield('content')
        </div>

        @guest()
            @include('layouts.footers.guest')
        @endguest

        <!-- Commented because navtabs includes same script -->
        <script src="{{ asset('argon') }}/vendor/jquery/dist/jquery.min.js"></script>

        <script src="{{ asset('argonfront') }}/js/core/popper.min.js" type="text/javascript"></script>
        <script src="{{ asset('argon') }}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

        @stack('js')
        <!-- Navtabs -->
        <script src="{{ asset('argonfront') }}/js/core/jquery.min.js" type="text/javascript"></script>
        <!--<script src="{{ asset('argonfront') }}/js/core/bootstrap.min.js" type="text/javascript"></script>-->

        <script src="{{ asset('argon') }}/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

        <!-- Nouslider -->
        <script src="{{ asset('argon') }}/vendor/nouislider/distribute/nouislider.min.js" type="text/javascript"></script>

        <!-- Argon JS -->
        <script src="{{ asset('argon') }}/js/argon.js?v=1.0.0"></script>

        <!-- Latest compiled and minified JavaScript -->
        <script src="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/4.0.0/js/jasny-bootstrap.min.js"></script>
        <!-- Custom js -->
        <script src="{{ asset('custom') }}/js/orders.js"></script>
         <!-- Custom js -->
        <script src="{{ asset('custom') }}/js/mresto.js"></script>
        <!-- AJAX -->
        <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>-->
        <!-- SELECT2 -->
        <script src="{{ asset('custom') }}/js/select2.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

        <!-- Google Map -->
        <script
            src="https://maps.google.com/maps/api/js?key=AIzaSyCDQsmKXBQgD4A0pIt5U_5TQjiUHsBu6Ms&amp;libraries=places&amp;callback=initAutocomplete"type="text/javascript">
        </script>

         <script src="{{ asset('custom') }}/js/rmap.js"></script>
         <!--< Import Vue >-->
        <script src="https://unpkg.com/vue@2.1.6/dist/vue.js"></script>
        <!-- Import AXIOS --->
        <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
        <!-- Flatpickr datepicker -->
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <!-- OneSignal -->
        <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
        <script>
             var ONESIGNAL_APP_ID = "{{ env('ONESIGNAL_APP_ID') }}";
             var USER_ID = '{{  auth()->user()?auth()->user()->id:"" }}';
        </script>
        <script>
            google.maps.event.addDomListener(window, 'load', initialize);
        function initialize() {
        var input = document.getElementById('autocomplete');
        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.addListener('place_changed', function() {
        var place = autocomplete.getPlace();
        console.log(place.geometry['location'].lat());
        console.log(place.geometry['location'].lng());
        $('#lat').val(place.geometry['location'].lat());
        $('#lng').val(place.geometry['location'].lng());
        });
        }


document.addEventListener("DOMContentLoaded", function(){
  document.querySelectorAll('.sidebar .nav-link').forEach(function(element){
    
    element.addEventListener('click', function (e) {

      let nextEl = element.nextElementSibling;
      let parentEl  = element.parentElement;	

        if(nextEl) {
            e.preventDefault();	
            let mycollapse = new bootstrap.Collapse(nextEl);
            
            if(nextEl.classList.contains('show')){
              mycollapse.hide();
            } else {
                mycollapse.show();
                // find other submenus with class=show
                var opened_submenu = parentEl.parentElement.querySelector('.submenu.show');
                // if it exists, then close all of them
                if(opened_submenu){
                  new bootstrap.Collapse(opened_submenu);
                }
            }
        }
    }); // addEventListener
  }) // forEach
}); 
        </script>
        <script src="{{ asset('custom') }}/js/onesignal.js"></script>

        @yield('js')
    </body>
</html>
