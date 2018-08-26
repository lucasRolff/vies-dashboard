@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Validation Date</th>
                            <th scope="col">Country</th>
                            <th scope="col">VAT Number</th>
                            <th scope="col">Valid</th>
                            <th scope="col">Client ID</th>
                            <th scope="col">Invoice ID</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $da)
                            <tr>
                                <td>{{ $da->id }}</td>
                                <td>{{ $da->validation_date }}</td>
                                <td>{{ $da->vat_country }}</td>
                                <td>{{ $da->vat_number }}</td>
                                <td>@if($da->valid == "1")<span class="badge badge-success">Valid</span>@else<span class="badge badge-danger">Invalid</span>@endif</td>
                                <td><a href="https://shop.hosting4real.net/admin/clientssummary.php?userid={{ $da->client_id }}">{{ $da->client_id }}</a></td>
                                <td><a href="https://shop.hosting4real.net/admin/invoices.php?action=edit&id={{ $da->invoice_id }}">{{ $da->invoice_id }}</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
