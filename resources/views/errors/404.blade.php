@extends('errors.layout')
@section('code', '404')
@section('heading', "That page isn't here.")
@section('body', "The link may be out of date, or the page may have moved. Everything else is still where you left it.")
@section('secondary')
<a href="{{ route('case-studies') }}" class="btn btn-ghost">See the work</a>
@endsection
