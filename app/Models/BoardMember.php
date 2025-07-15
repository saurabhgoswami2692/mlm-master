<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class BoardMember extends Model
{
    protected $fillable = ['board_id','user_id','position','referred_by','level','joining_amount','salary'];    
}
