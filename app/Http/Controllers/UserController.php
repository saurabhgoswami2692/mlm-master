<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\User;
use App\Models\BoardMember;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
class UserController extends Controller
{
    public function register(Request $req)
    {
        $ref = $req->query('refer_id', '');
        $product = Product::where('status',1)->first();

        $user_exist = User::where('id',$ref)->first();

        if(isset($user_exist) || $ref == ''){
            return view('viw_user_register', [
                'ref'     => $ref,
                'product' => $product
            ]); 
        } else {
            return view('viw_error');
        }   
    }
    
   
   public function store(Request $req)
    {

        $data = $req->all();
        if (!empty($data['name']) && !empty($data['email'])) {
            $email_exist = User::where('email',$data['email'])->first();
            if($email_exist){
                return redirect()->back()->with([
                    'class' => 'alert-danger',
                    'message' => 'This email id already exist, try with another.',
                ]);
                
                
            } else if ($data['password'] != $data['c_password']) {
                return redirect()->back()->with([
                    'class' => 'alert-danger',
                    'message' => 'Your passwords didn’t match. Try again.',
                ]);
            } else {

                $board_id           = 0;
                $position           = 0;
                $referral_by        = $data['refer_id'];
                $boardMembersLevel1 = BoardMember::where(['level' => 1])->get();

                if (isset($data['refer_id'])) {
                    $referral_by = $data['refer_id'];
                    $board_id_by_refer_id = BoardMember::where('id',$referral_by)->value('board_id');
                    $boardMembersLevel1 = BoardMember::where(['level' => 1, 'board_id' => $board_id_by_refer_id])->get();
                } 

                $uniqueBoards = $boardMembersLevel1->groupBy('board_id')->map(function ($members, $board_id) {
                    return [
                        'board_id'      => $board_id,
                        'total_members' => $members->count(),
                        'position'      => $members->count(),
                        'members'       => $members->toArray(),
                    ];
                })->values()->toArray();

                foreach ($uniqueBoards as $uniqueBoard) {                    
                    if ($uniqueBoard['total_members'] < 7) {
                        $board_id = $uniqueBoard['board_id'];
                        $position = $uniqueBoard['position'];
                        break;
                    } else {
                        $board_id = $uniqueBoard['board_id'];
                        $position = $uniqueBoard['position'];
                    }
                }

                if ($position < 7) {
                    if ($position == 0) {
                        $level      = 1;
                        $position   = 1;

                        // Create new board
                        $board_id = $this->create_board_id();
                    } else {
                        $level      = 1;
                        if(isset($referral_by)){
                            $board_id = BoardMember::where('user_id',$referral_by)->value('board_id');
                            $position = BoardMember::where('board_id', $board_id)->orderBy('position', 'desc')->value('position') + 1;
                        } else {
                            $position = $position + 1;
                        }
                        $board_id   = $board_id;

                        // echo $position; die;
                    }
                } else {
                    $level_2_exist = [
                        'board_id'    => BoardMember::where('level', 2)->pluck('board_id')->first(),
                        'max_position' => BoardMember::where('level', 2)->max('position'),
                    ];

                    if (!empty($level_2_exist['board_id'])) {
                        $position = $level_2_exist['max_position'] + 1;
                        $board_1_id = $level_2_exist['board_id'];
                    } else {
                        $position = 4;
                        $board_1_id = $this->create_board_id();
                    }

                        // Create 3 unique boards
                        $board_2_id = $this->create_board_id();
                        $board_3_id = $this->create_board_id();
                        
                        $all_members = $uniqueBoards[0]['members'];

                        $final_members = $this->split_board($all_members, $board_2_id, $board_3_id);

                        $updates = array_merge(
                            [[$all_members[0]['id'], $position, 2, $board_1_id]],
                            $final_members
                        );


                        // echo "<pre>";
                        // print_r($updates);
                        // die;

                        foreach ($updates as $u) { 
                            [$currentPosition, $newPosition, $newLevel, $newBoardId] = $u;

                            // $member = BoardMember::where(['id' => $currentPosition, 'level' => '1'])->first();
                            $member = BoardMember::where(['id' => $currentPosition])->first();

                            if ($member) {
                                $updateData = [
                                    'position' => $newPosition,
                                    'board_id' => $newBoardId,
                                ];
                                if ($newLevel !== null) {
                                    $updateData['level'] = $newLevel;
                                }

                                $member->update($updateData);

                                User::where('id', $member->user_id)->update([
                                    'current_board_id' => $newBoardId,
                                ]);
                            }
                        }

                        if (empty($level_2_exist['board_id'])) {
                            $this->create_dummy_users($board_1_id, 2, 1);
                        } 


                        $board_id  = $board_2_id;
                        $last_position = BoardMember::where('board_id', $board_id)->max('position');
                        $position = $last_position ? $last_position + 1 : 4;
                        $level     = 1;
                }   


                // Create new user
                $user = User::create([
                    'name'              => $data['name'],
                    'email'             => $data['email'],
                    'gender'            => $data['gender'],
                    'mobile'            => $data['mobile'],
                    'referred_by'       => $referral_by,
                    'current_board_id'  => $board_id,
                    'product_id'        => $data['product_id'],
                    'amount'            => $data['amount'],
                    'payment_method'    => $data['payment_method'],
                    'password'          => bcrypt($data['password']),
                ]);

                $user_id = $user->id;

                // Create board member
                $board_members = BoardMember::create([
                    'board_id'      => $board_id,
                    'user_id'       => $user->id,
                    'position'      => $position,
                    'referred_by'   => $referral_by,
                    'level'         => $level,
                ]);

                if(isset($referral_by) && !empty($referral_by)){    
                    $this->upgradeLevel($referral_by);
                }
                       
                // $bonus_update = $this->bonus_update($user->id);
                // $salary_update = $this->salary_update($user->id);
            }
        } else {
            return redirect()->back()->with([
                'class' => 'alert-danger',
                'message' => 'All fields are required.',
            ]);
            
        }

        $product = Product::where('status',1)->first();
        

        return redirect()->back();

        // return redirect()->route('login')->with([
        //     'class' => 'alert-success',
        //     'message' => 'User registered successfully.',
        // ]);

        
        // $json = [
        //     'class' => 'alert-success',
        //     // 'message' => 'User registered successfully.',
        //     'redirect_url' => route('login'),
        // ];
        // echo json_encode($json); 


        
        // return view('v')->with([
        //     'product' => $product,
        //     'class' => 'alert-success',
        //     'message' => 'User registered successfully.',

        // ]);
    }
   
        
    // public function store(Request $req)
    // {
    //     $data           = $req->all();
    //     $board_name     = 'Board_1';
    //     $users          = User::get();
    //     // echo "<pre>";
    //     // print_r(count($users));
    //     // die;

    //     if(count($users) == 0 || count($users) > 7){
    //         $add_board      = Board::create(['board_name' => $board_name])->id;
    //     } else {
            
    //     }
        
    //     // Create new user
    //     $user = User::create([
    //         'name'              => $data['name'],
    //         'email'             => $data['email'],
    //         'gender'            => $data['gender'],
    //         'mobile'            => $data['mobile'],
    //         'referred_by'       => $data['refer_id'],
    //         'current_board_id'  => $add_board,
    //         'product_id'        => $data['product_id'],
    //         'amount'            => $data['amount'],
    //         'payment_method'    => $data['payment_method'],
    //         'password'          => bcrypt($data['password']),
    //     ]);
    // }

    public function bonus_update(int $user_id): bool
    {
        $level = BoardMember::where('user_id', $user_id)->value('level');
        if (!$level) {
            return false;        // no board row for this user
        }

        $amount = Payment::where('level', $level)->value('amount');
        $amount = $this->toNumeric($amount);
        if ($amount === 0) {
            return false;        // nothing to add
        }
        return User::whereKey($user_id)->increment('bonus', $amount) > 0;
    }

    public function salary_update(int $user_id): bool
    {
        $referral_count = User::where('referred_by', $user_id)->count();
        $required_referrals = [
            2 => 3, 3 => 6, 4 => 12, 5 => 24,
            6 => 48, 7 => 96, 8 => 192, 9 => 384,
            10 => 768, 11 => 1536,
        ];

        $level = BoardMember::where('user_id', $user_id)->value('level');
        if (!$level || $referral_count < ($required_referrals[$level] ?? PHP_INT_MAX)) return false;

        $amount = Payment::where('level', $level)->value('salary');
        $amount = $this->toNumeric($amount);
        if ($amount === 0) return false;

        return User::whereKey($user_id)->increment('salary', $amount) > 0;
    }

    private function toNumeric($value): float
    {
        if (is_null($value)) return 0;
        if (is_string($value)) {
            $value = str_replace(['₹', '$', ',', ' '], '', $value);
        }
        return is_numeric($value) ? (float)$value : 0;
    }


    public function create_board_id()
    {
        $board_name = 'Board_' . RAND(10, 1000); 
        return Board::create(['board_name' => $board_name])->id;
    }

    public function upgradeLeveL($referral_by)
    {
        if (isset($referral_by)) {
            $count_by_referred_user = User::where('referred_by', $referral_by)->count();

            $levels_array = [
                '2' => '3',
                '3' => '6',
                '4' => '12',
                '5' => '24',
                '6' => '48',
                '7' => '96',
                '8' => '192',
                '9' => '384',
                '10' => '768',
                '11' => '1536'
            ];

            foreach ($levels_array as $key => $level_array) {
                $referred_user_detail = BoardMember::where(['user_id' => $referral_by, 'level' => $key])->first();
                if(isset($referred_user_detail)){
                    if(isset($referred_user_detail)){
                        $user_count = BoardMember::where('board_id',$referred_user_detail->board_id)->count() ;
                    }

                    if ($count_by_referred_user == $level_array) {
                        if($user_count < 7){
                            $level_exist = BoardMember::where('level', $key + 1)->first();
                            if (empty($level_exist)) {

                                $board_id = $this->create_board_id();

                                $users = User::where('id', $referred_user_detail->user_id)->update([
                                    'current_board_id'  => $board_id,
                                ]);

                                $board = BoardMember::where('user_id', $referred_user_detail->id)->update([
                                    'position' => 4,
                                    'level'    => $key + 1
                                ]);
                                
                                // create dummy users for other levels
                                $this->create_dummy_users($board_id, $key , 0);

                            } else {

                                $users = User::where('id', $referred_user_detail->user_id)->update([
                                    'current_board_id'  => $level_exist->board_id,
                                ]);

                                $board = BoardMember::where('user_id', $referred_user_detail->id)->update([
                                    'position' => $level_exist->position + 1,
                                    'level'    => $key
                                ]);
                            }
                        } else {
                            $salary = Payment::where('level', $key)->value('salary');
                            $salary_update = BoardMember::where('user_id',$referral_by)->update([
                                'salary'    => $salary,
                            ]);
                        }
                        
                    }
                }
            }
        }

        return true;
    }

    public function create_dummy_users($board_id,$level,$flag){
        $referral_by = null;
        for ($i = 1; $i <= 3; $i++) {
            // Create new user
           do {
                $random = rand(1000, 9999); // Increase range to reduce collision
                $name = 'dummy_' . $random;
                $email = $name . '@gmail.com';
            } while (User::where('email', $email)->exists());

            $user = User::create([
                'name'              => $name,
                'email'             => $email,
                'gender'            => '',
                'mobile'            => '',
                'referred_by'       => $referral_by,
                'current_board_id'  => $board_id,
                'password'          => bcrypt('1234'),
            ]);


            $user_id = $user->id;

            // Create board member
            $board_members = BoardMember::create([
                'board_id' => $board_id,
                'user_id' =>  $user_id,
                'position' => $i,
                'level' => $level,
            ]);
        }

        return true;
    }

    public function user_login()
    {
        return view('viw_user_login');
    }

   public function login(Request $req)
    {
        $data = $req->all();

        $user = User::where('email', $data['email'])->first();

        if ($user && Hash::check($data['password'], $user->password)) {
            // Store user info in session
            session([
                'user_id'    => $user->id,
                'user_name' => $user->name,
                'user_email' => $user->email,
            ]);

            return redirect()->route('user_dashboard');

        } else {
            return redirect()->back()->with([
                'class'=>'alert-danger',
                'msg'=>'Invalid username password!!!'
            ]);
        }
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('login'); // Replace 'view_login' with your actual login route name
    }

    public function split_board($members, $board_1_id, $board_2_id){
                $board_1 = [];
                $board_2 = [];
                // $members = $uniqueBoards[0]['members'];

                // Skip position 1 (root)
                $positionMap = [];
                foreach ($members as $member) {
                    if ($member['position'] != 1) {
                        $positionMap[$member['position']] = $member;
                    }
                }

                // echo "<pre>";
                // print_r($positionMap);
                // die;


                // Assign user with position 2 to board_1
                $board_1[] = $positionMap[2];
                $referrer_2 = $positionMap[2]['user_id'];

                // Check user 3
                $user3 = $positionMap[3];
                if (!empty($user3['referred_by']) && $user3['referred_by'] == $referrer_2) {
                    $board_1[] = $user3;

                    // Find next user without referred_by to start board_2
                    $board2_started = false;
                    foreach ([4, 5, 6, 7] as $pos) {
                        if (empty($positionMap[$pos]['referred_by'])) {
                            $board_2[] = $positionMap[$pos];
                            $board2_root = $positionMap[$pos]['user_id'];
                            $board2_started = true;
                            break;
                        }
                    }
                    if (!$board2_started) {
                        // fallback if all remaining members have referred_by set
                        $board_2[] = $positionMap[4]; // just pick 4
                        $board2_root = $positionMap[4]['user_id'];
                    }
                } else {
                    // user 3 is not referred by user 2, so he starts board_2
                    $board_2[] = $user3;
                    $board2_root = $user3['user_id'];
                }


                // Remaining positions: 4 to 7
                foreach ([4, 5, 6, 7] as $pos) {
                    if (!isset($positionMap[$pos])) continue;
                    $member = $positionMap[$pos];

                    // If already assigned to a board, skip
                    if (in_array($member, $board_1, true) || in_array($member, $board_2, true)) {
                        continue;
                    }

                    // Assign based on referred_by
                    if (!empty($member['referred_by'])) {
                        if (in_array($member['referred_by'], array_column($board_1, 'user_id'))) {
                            $board_1[] = $member;
                        } elseif (in_array($member['referred_by'], array_column($board_2, 'user_id'))) {
                            $board_2[] = $member;
                        } else {
                            // fallback: assign based on balance
                            (count($board_1) <= count($board_2)) ? $board_1[] = $member : $board_2[] = $member;
                        }
                    } else {
                        // No referred_by → use default row split
                        if (in_array($pos, [4, 5])) {
                            $board_1[] = $member;
                        } else {
                            $board_2[] = $member;
                        }
                    }
                }

                
                $final_board_1 = [];
                $final_board_2 = [];

                foreach (array_values($board_1) as $index => $member) {
                    $final_board_1[] = [$member['user_id'], $index + 1, null , $board_1_id];
                }

                foreach (array_values($board_2) as $index => $member) {
                    $final_board_2[] = [$member['user_id'], $index + 1, null ,$board_2_id];
                }



                // echo "<pre>";
                // print_r($final_board_1);
                // print_r($final_board_2);

                // die;



                // Combine both boards if needed:
                $final_members = array_merge($final_board_1, $final_board_2);

                return $final_members;
    }

    /*
    
        public function store(Request $req)
    {

        $data = $req->all();
        if (!empty($data['name']) && !empty($data['email'])) {
            $email_exist = User::where('email',$data['email'])->first();
            if($email_exist){
                return redirect()->back()->with([
                    'class' => 'alert-danger',
                    'message' => 'This email id already exist, try with another.',
                ]);
                
                
            } else if ($data['password'] != $data['c_password']) {
                return redirect()->back()->with([
                    'class' => 'alert-danger',
                    'message' => 'Your passwords didn’t match. Try again.',
                ]);
            } else {

                if (isset($data['refer_id'])) {
                    // $referral_code = $data['refer_id'];
                    $referral_by = $data['refer_id'];
                } else {
                    // $referral_code = null;
                    $referral_by = null;
                }

                $board_id = 0;
                $position = 0;
                $boardMembersLevel1 = BoardMember::where('level', 1)->get();

                $uniqueBoards = $boardMembersLevel1->groupBy('board_id')->map(function ($members, $board_id) {
                    return [
                        'board_id'      => $board_id,
                        'total_members' => $members->count(),
                        'position'      => $members->count(),
                        'members'       => $members->toArray(),
                    ];
                })->values()->toArray();

                foreach ($uniqueBoards as $uniqueBoard) {
                    if ($uniqueBoard['total_members'] < 7) {
                        $board_id = $uniqueBoard['board_id'];
                        $position = $uniqueBoard['position'];
                        break;
                    } else {
                        $board_id = $uniqueBoard['board_id'];
                        $position = $uniqueBoard['position'];
                    }
                }

                if ($position < 7) {

                    if ($position == 0) {
                        $level      = 1;
                        $position   = 1;

                        // Create new board
                        $board_id = $this->create_board_id();
                    } else {
                        $level      = 1;
                        $position   = $position + 1;
                        $board_id   = $board_id;
                    }
                } else {

                    $level_2_exist = [
                        'board_id'    => BoardMember::where('level', 2)->pluck('board_id')->first(),
                        'max_position' => BoardMember::where('level', 2)->max('position'),
                    ];

                    if (!empty($level_2_exist['board_id'])) {
                        $position = $level_2_exist['max_position'] + 1;
                        $board_1_id = $level_2_exist['board_id'];
                    } else {
                        $position = 4;
                        $board_1_id = $this->create_board_id();
                    }

                        // Create 3 unique boards
                        $board_2_id = $this->create_board_id();
                        $board_3_id = $this->create_board_id();

                        $all_members = $uniqueBoards[0]['members'];

                        $updates = [
                            [1, $position, 2, $board_1_id],
                            [2, 1, null, $board_2_id],
                            [4, 2, null, $board_2_id],
                            [5, 3, null, $board_2_id],
                            [3, 1, null, $board_3_id],
                            [6, 2, null, $board_3_id],
                            [7, 3, null, $board_3_id],
                        ];

                        foreach ($updates as $u) {
                            [$currentPosition, $newPosition, $newLevel, $newBoardId] = $u;

                            $member = BoardMember::where(['position' => $currentPosition, 'level' => '1'])->first();

                            if ($member) {
                                $updateData = [
                                    'position' => $newPosition,
                                    'board_id' => $newBoardId,
                                ];
                                if ($newLevel !== null) {
                                    $updateData['level'] = $newLevel;
                                }

                                $member->update($updateData);

                                User::where('id', $member->user_id)->update([
                                    'current_board_id' => $newBoardId,
                                ]);
                            }
                        }

                        if (empty($level_2_exist['board_id'])) {
                            $this->create_dummy_users($board_1_id, 2, 1);
                        }

                        $board_id  = $board_2_id;
                        $position  = 4;
                        $level     = 1;
                }   


                // Create new user
                $user = User::create([
                    'name'              => $data['name'],
                    'email'             => $data['email'],
                    'gender'            => $data['gender'],
                    'mobile'            => $data['mobile'],
                    'referred_by'       => $referral_by,
                    'current_board_id'  => $board_id,
                    'product_id'        => $data['product_id'],
                    'amount'            => $data['amount'],
                    'payment_method'    => $data['payment_method'],
                    'password'          => bcrypt($data['password']),
                ]);

                $user_id = $user->id;

                // Create board member
                $board_members = BoardMember::create([
                    'board_id' => $board_id,
                    'user_id' =>  $user_id,
                    'position' => $position,
                    'referred_by' => $referral_by,
                    'level' => $level,
                ]);

                if(isset($referral_by) && !empty($referral_by)){    
                    $this->upgradeLevel($referral_by);
                }
                       
                $bonus_update = $this->bonus_update($user_id);
                $salary_update = $this->salary_update($user_id);
            }
        } else {
            return redirect()->back()->with([
                'class' => 'alert-danger',
                'message' => 'All fields are required.',
            ]);
            
        }

        $product = Product::where('status',1)->first();
        

        return redirect()->back();

        // return redirect()->route('login')->with([
        //     'class' => 'alert-success',
        //     'message' => 'User registered successfully.',
        // ]);

        /*
        $json = [
            'class' => 'alert-success',
            // 'message' => 'User registered successfully.',
            'redirect_url' => route('login'),
        ];
        echo json_encode($json); */


        /*
        return view('v')->with([
            'product' => $product,
            'class' => 'alert-success',
            'message' => 'User registered successfully.',

        ]);  
    } 
    
    
    */

}
