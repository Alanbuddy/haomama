@extends('layout.app')

@section('title')
首页
@endsection('title')

@section('content')
.container{:id =>"33"}
    .row
        .col-md-10.col-md-offset-1
            .panel.panel-default
                .panel-heading Welcome!
                .panel-body Your Application's Landing Page.
                    - foreach($items as $item)
                        %div= $item->name
@endsection('content')
