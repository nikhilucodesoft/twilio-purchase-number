<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class PurchaseNumber  extends Model
{
   
    protected $table = "purchase_number";
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'address_sid',
        'customer_name',
        'phone_number',
        'voice_url',
        'sms_url',
        'street',
        'city',
        'region',
        'postal_code',
        'country_code'
    ];

    
}
