<?php
declare(strict_types=1); 
namespace App\Payments;
class PaymentFactory
{
    public static function getPayment(string $type) : PaymentInterface
    {
    return ($type=='dd')?new Debit():new Credit();
    }
}