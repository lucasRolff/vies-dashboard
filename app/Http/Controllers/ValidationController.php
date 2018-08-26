<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use VatCalculator;
use App\Validation;

class ValidationController extends Controller
{
    public function addAction(Request $request)
    {
        $vatnumber  = $request->vat_number;
        $client_id  = $request->client_id;
        $invoice_id = $request->invoice_id;
        $token      = $request->token;

        if($token != "FmkafFDZnvlnwEeDKzO0xZhtbnruhNQf")
        {
            abort(403, "You probably shouldn't be here.");
        }

        try {
            $validVAT = VatCalculator::getVATDetails($vatnumber);
        } catch( VATCheckUnavailableException $e ){
            abort(503, "VIES is down.. Surprise?");
        }

        $validation = new Validation();
        $validation->validation_date = $validVAT->requestDate;
        $validation->vat_country = $validVAT->countryCode;
        $validation->vat_number = $validVAT->vatNumber;
        $validation->valid = $validVAT->valid;
        $validation->vies_response = json_encode($validVAT);
        $validation->client_id = $client_id;
        $validation->invoice_id = $invoice_id;

        $validation->save();

        return redirect()->route('dashboard');
    }
}
