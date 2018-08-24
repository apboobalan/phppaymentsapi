<?php
use App\Payments\PaymentFactory;
use App\Payments\Credit;
use App\Payments\Debit;

class PaymentTest extends TestCase
{
    public function testGenerateCreditType() {
        $payment = PaymentFactory::getPayment('cc');
        $this->assertTrue($payment instanceof Credit);
    }
    public function testGeneratedebitType() {
        $payment = PaymentFactory::getPayment('dd');
        $this->assertTrue($payment instanceof Debit);
    }

    public function testCreditCharge() {
        $payment = PaymentFactory::getPayment('cc');
        $this->assertTrue($payment->charge(100)==110);
    }
    public function testDebitCharge() {
        $payment = PaymentFactory::getPayment('dd');
        $this->assertTrue($payment->charge(100)==107);
    }
}
