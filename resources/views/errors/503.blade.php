@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>503: {{ $exception->getMessage() }}</h2>
    </div>
@endsection
