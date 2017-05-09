{{--ovom komadnom inkludamo layout napravljen u app.php--}}
@extends('layouts.app')

@section('content')

    <h1>Posts page {{$id}} {{$name}} {{$password}} </h1>

@stop

@section('footer')

    <script> alert('Hello') </script>

@stop