@extends('layouts.app')


@section('content')

    <div class="container">
        <div class="row col-sm-8 col-sm-offset-2">
            <h1 class="text-center">ElasticSearch</h1>
            @yield('elastic.content')
        </div>
    </div>

@endsection