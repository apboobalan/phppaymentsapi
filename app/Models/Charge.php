<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
 
class Charge extends Model 
{
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'charges'; 
}