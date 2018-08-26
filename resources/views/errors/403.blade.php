@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>403: {{ $exception->getMessage() }}</h2>
    </div>
@endsection
