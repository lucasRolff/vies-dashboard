<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use VatCalculator;
use App\Validation;
use VerumConsilium\Browsershot\Facades\Screenshot;
use VerumConsilium\Browsershot\Facades\PDF;
use Illuminate\Support\Facades\Log;

class ValidationController extends Controller
{
    public function addAction(Request $request)
    {
        $vatnumber  = $request->vat_number;
        $client_id  = $request->client_id;
        $invoice_id = $request->invoice_id;
        $token      = $request->token;

        if ($token != env('VIES_ACCESS_TOKEN', 'supersecure')) {
            abort(403, "You probably shouldn't be here.");
        }

        try {
            $time_start = microtime(true);
            $validVAT = VatCalculator::getVATDetails($vatnumber);
            $time_end_vies = microtime(true);

            $screenshotStoredPath = Screenshot::loadUrl("http://ec.europa.eu/taxation_customs/vies/vatResponse.html?memberStateCode=" . $validVAT->countryCode . "&number=" . $validVAT->vatNumber . "&requesterMemberStateCode=" . env('VIES_REQUESTER_CC', 'XX') . "&requesterNumber=" . env('VIES_REQUESTER_NUMBER', '00000000') . "&action=check&check=Verify")->store('dumps');
            $time_end_pdf = microtime(true);

            $execution_time_vies = ($time_end_vies - $time_start);
            $execution_time_pdf = ($time_end_pdf - $time_start);

            Log::info('VIES call time: ' . $execution_time_vies . '; Screenshot Generation time: ' . $execution_time_pdf . ' for VAT Number: ' . "$validVAT->vatNumber");
        } catch (VATCheckUnavailableException $e) {
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
        $validation->vies_image = $screenshotStoredPath;

        $validation->save();

        return redirect()->route('dashboard');
    }
}
