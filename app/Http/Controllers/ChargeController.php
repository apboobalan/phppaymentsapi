<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Charge;
use App\Models\Payment;
use App\Payments\PaymentFactory;
use Illuminate\Support\Facades\Validator;
use Log;

class ChargeController extends Controller
{
    public function create(Request $request) {
        if(!$this->isValidParams($request)) {
            return response()->json(array("message" => "Invalid parameters", "code"=> 400 ), 400);
        }

        if(Charge::where('id', $request->id)->first()) {
            return response()->json(array("message" => "Data conflict", "code"=> 409 ), 409); 
        }

        $payment = Payment::where('id', $request->payment_id)->first();
        $type = ($payment)?$payment->type:'';
        if(!$type){
            return response()->json(array("message" => "Resource doesn't exist", "code"=> 404 ), 404); 
        }
        $payment_type = PaymentFactory::getPayment($type);

        $charge = new Charge();
        $charge->id = $request->id;
        $charge->payment_id = $request->payment_id;
        $charge->amount = $payment_type->charge($request->amount);
        $charge->save();

        return response()->json(array("id"=>$charge->id,"payment_id"=>$charge->payment_id,"amount"=>floatval($charge->amount)), 200);
    }

    public function getAllCharges(Request $request) {
        $charges = Charge::all();
        if (count($charges)>0) {
            return response()->json($this->formatCharges($charges), 200);
        } else {
            return response()->json(array(), 200);
        }
    }

    public function getCharge(Request $request, string $id) {
        $charge = Charge::where('id', $id)->first();
        if (isset($charge)) {
            return response()->json(array("payment_id"=>$charge->payment_id,"amount"=>floatval($charge->amount)), 200);
        } else {
            return response()->json(array( "message"=> "Resource doesn't exist", "code"=> 404 ), 404);
        }
    }

    public function delete(Request $request) {
        Charge::truncate();
        return response()->json(array("message"=> "charges collection removed","code"=> 200), 200);
    }

    private function isValidParams(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|string',
            'payment_id' => 'required|string',
            'amount' => 'required|numeric'
        ]);
        Log::error('Validation failed in Charge->',$validator->errors()->all());
        if ($validator->fails()) {
            return false;
        }
        return true;
    }

    private function formatCharges($charges) {
        $formattedCharges=array();
        foreach($charges as $charge) {
            array_push($formattedCharges,array("payment_id"=>$charge->payment_id,"amount"=>floatval($charge->amount)));
        }
        return $formattedCharges;
    }
}
