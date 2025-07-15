<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Board;
use App\Models\BoardMember;
use App\Models\PaymentRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Validation\ValidationException;

class PaymentController extends Controller
{
    public function index(){ 
        $user_id = session('user_id');
        $users = User::where('users.id',$user_id)
            ->join('board_members','board_members.user_id','=','users.id')
            ->join('payments','payments.level','=','board_members.level')
            ->first();

        return view('viw_withdraw_request',compact('users'));
    }

    public function payment_request(Request $req){
        $payment_request_data = $req->all();
        $json['msg_class']  = 'alert-danger';

        $payment_request = PaymentRequest::create([
            'user_id'       => $payment_request_data['user_id'],
            'payment_id'    => $payment_request_data['payment_id'],
            'amount'        => $payment_request_data['amount']
        ]); 

        $update_user = User::where('id',$payment_request_data['user_id'])->update([
            'payment_request'   => 1,
        ]);

        if($payment_request){
            $json['msg_class']  = 'alert-success';
            $json['message'] = "Withdrawl request successfully sent.";
        } else {
            $json['message'] = "Something went wrong!!!";
        }

        echo json_encode($json);       
    }

    public function payout_request(Request $req){
        $search_key = $req->get('search');

        $query = User::where('users.payment_request', '1') // Fix: prefix with table name
            ->join('payment_requests', 'payment_requests.user_id', '=', 'users.id');

        if (!empty($search_key)) {
            $query->where(function($q) use ($search_key) {
                $q->where('users.name', 'like', '%' . $search_key . '%')
                ->orWhere('users.email', 'like', '%' . $search_key . '%')
                ->orWhere('users.mobile', 'like', '%' . $search_key . '%');
            });
        }

        $payout_requests = $query->select(
                'users.name',
                'users.email',
                'users.mobile',
                'payment_requests.amount'
            )->get();


        return view('viw_payout_requests',compact('payout_requests'));
        
    }
}