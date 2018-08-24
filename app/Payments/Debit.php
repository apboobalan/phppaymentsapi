<?php
declare(strict_types=1); 
namespace App\Payments;
use App\Models\DebitPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Log;
class Debit implements PaymentInterface
{
    public function create(Request $request) : array {
        $validator = Validator::make($request->all(), [
            'id' => 'required|string',
            'name' => 'required|string',
            'iban' => 'required|string'
        ]);
        Log::error('Validation failed in Debit payment->',$validator->errors()->all());
        if ($validator->fails()) {
            return array(
                'error' => true,
                'message' => $validator->errors()->all()
            );
        }

        $payment = new DebitPayment();
        $payment->id = $request->id;
        $payment->name = $request->name;
        $payment->iban = $request->iban;
        $payment->save();
        return array('error'=>false,'name'=>$payment->name,'iban'=>$payment->iban);
    }
    
    public function charge(float $amount) : float {
    return $amount + ($amount*0.07);
    }

    public function delete() {
        DebitPayment::truncate();
    }
}