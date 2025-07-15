<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReferralLog  extends Model
{
    protected $fillable = ['referrer_id','referred_user_id'];
}
