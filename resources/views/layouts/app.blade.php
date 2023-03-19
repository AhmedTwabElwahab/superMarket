<?php
use App\helper\Language;
/**
 * @var Language $lang
 *
 */
$language = str_replace('_', '-', app()->getLocale());
?>
    <!doctype html>
<html lang="{{$language}}" dir= "{{ Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocaleDirection() }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">

    @auth()
        <title>{{$lang->text($title)}}</title>
    @elseauth()
        <title>superMarket</title>
    @endauth
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('images/icon/marketplace.ico')}}">
    @if($language == 'ar')
        <link rel="stylesheet" href="{{asset('css/libraries/bootstrap/bootstrap.rtl.css')}}">
    @elseif($language == 'en')
        <link rel="stylesheet" href="{{asset('css/libraries/bootstrap/bootstrap.min.css')}}">
    @endif
    <link rel="stylesheet" href="{{asset('css/libraries/fontAwesome/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/main.css')}}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+Bhaijaan+2&display=swap" rel="stylesheet">
    <link href="{{asset('css/libraries/toastr/toastr.min.css')}}" rel="stylesheet"/>
    {{-- Start style include  --}}
    @isset($CSS)
        @if(file_exists(public_path().DIRECTORY_SEPARATOR.$CSS))
            <link rel="stylesheet" href="{{asset($CSS)}}"/>
        @endif
    @endisset
    {{-- Start style include  --}}
</head>
<body>

    @guest()
        @yield('content')
    @endguest
    @auth()
<div class="col-12 d-flex mainContainer">
    @include('layouts.sidebar')
    <div class="main-content in-active" >
        <div class="container-fluid">
            <div id="toast-container"></div>
            @include( 'layouts.nav')
            {{-- Start Contant --}}
            @yield('content')
            {{-- End Contant --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
</div>
    @endauth
{{-- Start script--}}
<script src="{{asset('js/libraries/jQuery/jquery-3.6.1.min.js')}}"></script>
<script src="{{asset('js/libraries/bootstrap/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('js/libraries/fontAwesome/all.min.js')}}"></script>
<script src="{{asset('js/libraries/datatables/datatables.min.js')}}"></script>
<script src="{{asset('js/libraries/toastr/toastr.min.js')}}"></script>
<script src="{{asset('js/libraries/datatables/DataTables-1.12.1/dataTables.bootstrap5.min.js')}}"></script>
<script src="{{asset('js/main.js')}}"></script>

{{-- Start script include  --}}

@isset($js)
    @if(file_exists(public_path().DIRECTORY_SEPARATOR.$js))
        <script  src="{{asset($js)}}"></script>
    @endif
@endisset
{{-- End script include  --}}
{{-- End script--}}



{{--@if(Session::has('success'))--}}
{{--    <script>--}}
{{--        Notify('{{Session::get('success')}}','success');--}}
{{--    </script>--}}
{{--@endif--}}
{{--@if(Session::has('error'))--}}
{{--    <script>--}}
{{--        Notify('{{Session::get('error')}}','danger');--}}
{{--    </script>--}}
{{--@endif--}}


</body>
</html>
