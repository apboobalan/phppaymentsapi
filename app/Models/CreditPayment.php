<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
 
class CreditPayment extends Model 
{
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'credit_pay'; 
}