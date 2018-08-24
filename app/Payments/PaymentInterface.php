<?php
declare(strict_types=1); 
namespace App\Payments;
use Illuminate\Http\Request;
interface PaymentInterface
{
    public function create(Request $request) : array;
    public function charge(float $amount) : float;
    public function delete();
}