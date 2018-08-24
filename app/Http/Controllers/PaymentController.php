<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Payments\PaymentFactory;
use Illuminate\Support\Facades\Validator;
use Log;

class PaymentController extends Controller
{
    public function create(Request $request)
    {
        if(!$this->isValidParams($request)) {
            return response()->json(array("message" => "Invalid parameters", "code"=> 400 ), 400);
        }

        if(Payment::where('id', $request->id)->first()) {
            return response()->json(array("message" => "Data conflict", "code"=> 409 ), 409); 
        }

        $payment = PaymentFactory::getPayment($request->type);
        $paymentResponse = $payment->create($request);
        if($paymentResponse['error']) {
            return response()->json(array("message" => "Invalid parameters", "code"=> 400 ), 400);
        }

        $payment = new Payment();
        $payment->id = $request->id;
        $payment->type = $request->type;
        $payment->save();

        unset($paymentResponse['error']);
        $payment = array_merge(array('id'=>$payment->id,'type'=>$payment->type),$paymentResponse);
        
        return response()->json($payment, 200);
    }

    public function delete(Request $request) {
        Payment::truncate();
        $payment = PaymentFactory::getPayment('cc');
        $payment->delete();
        $payment = PaymentFactory::getPayment('dd');
        $payment->delete();
        return response()->json(array("message"=> "payments collection removed","code"=> 200), 200);
    }

    private function isValidParams(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|string',
            'type' => 'required|string'
        ]);

        Log::error('Validation failed in Payment->',$validator->errors()->all());
        if ($validator->fails()) { return false; }

        $type = $request->type;
        if(!($type=='cc'||$type=='dd')){ return false;}
        return true;
    }
}
