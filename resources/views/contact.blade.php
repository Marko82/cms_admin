{{--ovom komadnom inkludamo layout napravljen u app.php--}}
@extends('layouts.app')

@section('content')

    <h1>Contact page </h1>

    <ul>
    {{--count je ugrađena f-ja--}}
    @if(count($people))  {{--ako postoji neki podaci u array-u--}}
        @foreach($people as $person)
            <li> {{$person}} </li>
        @endforeach

    @endif
    </ul>
@stop
