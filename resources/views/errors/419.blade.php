@extends('errors.layout')
@section('code', '419')
@section('heading', 'That form expired.')
@section('body', "Forms time out after a while for security. Go back, reload the page and send it again — your details were not lost.")
@section('secondary')
<a href="{{ route('contact') }}" class="btn btn-ghost">Back to contact</a>
@endsection
