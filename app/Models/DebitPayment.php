<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
 
class DebitPayment extends Model 
{
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'debit_pay'; 
}