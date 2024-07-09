@php
    $uname=Auth::user()->name??'';
@endphp
{{env('APP_NAME').' '.($uname?'('.$uname.')':'')}}