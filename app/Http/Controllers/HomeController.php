<?php
namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\BoardMember;
use App\Models\Payment;
use App\Models\PaymentRequest;
use App\Models\User;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    // for admin
    public function index(){
        $total_users  = User::count();
        $total_boards = Board::count();
        $total_payout_requests = PaymentRequest::count();

        return view('viw_dashboard')->with([
            'total_users' => $total_users,
            'total_boards' => $total_boards,
            'total_payout_requests' => $total_payout_requests
        ]);

    }

    // for user
    public function user_dashboard(Request $req){

        if (!session()->has('user_id')) {
            return redirect('/login');
        }   

        $data               = array();
        $data['user_id']    = session('user_id');
        $data['user_email'] = session('user_email');

       $dashboard_data = [];

        // Fetch user by email
        $users = User::where('email', $data['user_email'])->first();

        // echo "<pre>";
        // print_r($users);
        // die;    

        if ($users) {
            // Fetch board member info
            $board_member = BoardMember::where('user_id', $users->id)
                ->select('position', 'level')
                ->first();

            $total_referrals = User::where('referred_by', $users->id)->count();
            // echo $total_referrals; 
            $require_user = 0;
            $level_upgrade = null;

            if ($board_member && $board_member->level >= 2 && $board_member->level <= 11) {
                // Required referrals = 3 * (2 ^ (level - 3))
                // Example: level 2 → 3, level 3 → 6, level 4 → 12, level 5 → 24, ...
                if($board_member->level == 3){
                    
                }
                $required_referrals = 3 * pow(2, $board_member->level - 3);
                $require_user  = $required_referrals - $total_referrals;
                $level_upgrade = $board_member->level + 1;
            } else {
                $require_user  = isset($board_member->position) ? (7 - $board_member->position) : null;
                $level_upgrade = isset($board_member->level) ? ($board_member->level + 1) : null;
            }


            // Total referrals
            $total_referrals = User::where('referred_by', $users->id)->count();


            $require_user_board_id   = BoardMember::where('user_id',$users->id)->first();
        
            if($require_user_board_id['position'] == 1){
                $require_user            = 7 - BoardMember::where(['board_id' => $require_user_board_id['board_id']])->count();
            } else {
                $require_user = 6;
            }

            $balance        = Payment::where('level', $board_member->level)->value('amount');
            $joining_amount = BoardMember::where('user_id', $users->id)->value('joining_amount');
            $wallet_balance = $balance + $joining_amount;

            // Prepare dashboard data
            $dashboard_data = [
                'users'             => $users,
                'require_user'      => $require_user,
                'level_upgrade'     => $level_upgrade,
                'total_referrals'   => $total_referrals,
                'wallet_balance'    => $wallet_balance,
                'level'             => $board_member->level,
            ];
        } else {
            // Optional: handle case when user is not found
            $dashboard_data = [
                'error' => 'User not found'
            ];
        }

        
        
        return view('viw_user_dashboard')->with([
            'dashboard_data'      => $dashboard_data,
            // 'referred_users' => $referred_users
        ]);
    }
    
}
