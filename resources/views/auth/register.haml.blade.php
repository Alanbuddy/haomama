@extends('layout.app')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/register.css') }}">
@endsection

@section('content')
.main
  %span hello
@endsection

@section('script')
<script src="{{ mix('/js/register.js') }}"></script>
@endsection


