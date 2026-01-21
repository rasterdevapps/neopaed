@extends('emails.email_header')
@section('content')

Hi {{ $user['name'] }} ,


 <br />Click here to reset your password: <a href="{{ url('password/reset/'.$token) }}">{{ url('password/reset/'.$token) }}</a>


@endsection