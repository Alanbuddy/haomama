@extends('layout.app')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/teacher.css') }}">

@endsection
@section('content')
.head-div
  %img.back{src: "/icon/back2.png"}

@endsection

@section('script')
<script src= "{{ mix('/js/teacher.js') }}"></script>
@endsection