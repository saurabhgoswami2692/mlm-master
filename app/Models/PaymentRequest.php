<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentRequest extends Model
{
    protected $fillable = ['user_id','payment_id','amount'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
