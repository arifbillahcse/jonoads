@extends('errors.layout')
@section('code', '500')
@section('heading', 'Something went wrong on our side.')
@section('body', "This one is ours, not yours. It has been logged and we're on it — try again in a moment.")
@section('secondary')
<a href="{{ route('contact') }}" class="btn btn-ghost">Tell us about it</a>
@endsection
