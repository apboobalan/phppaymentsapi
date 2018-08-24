<?php
declare(strict_types=1); 
namespace App\Payments;
use App\Models\CreditPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Log;
class Credit implements PaymentInterface
{
    public function create(Request $request) : array {
        $validator = Validator::make($request->all(), [
            'id' => 'required|string',
            'name' => 'required|string',
            'cc' => 'required|string',
            'ccv' => 'required|string',
            'expiry' => 'required|date'
        ]);
        Log::error('Validation failed in Credit payment->',$validator->errors()->all());
        if ($validator->fails()) {
            return array(
                'error' => true,
                'message' => $validator->errors()->all()
            );
        }


        $payment = new CreditPayment();
        $payment->id = $request->id;
        $payment->name = $request->name;
        $payment->expiry = $request->expiry;
        $payment->cc = $request->cc;
        $payment->ccv = $request->ccv;
        $payment->save();
        return array('error'=>false,'name'=>$payment->name,'expiry'=>$payment->expiry,'cc'=>$payment->cc,'ccv'=>$payment->ccv);
    }

    public function charge(float $amount) : float {
    return $amount + ($amount*0.1);
    }

    public function delete() {
        CreditPayment::truncate();
    }
}