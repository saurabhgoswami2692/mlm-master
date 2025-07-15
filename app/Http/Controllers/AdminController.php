<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Board;
use App\Models\BoardMember;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    public function index(){   
        return view('viw_admin_login');
    }

    public function adminregister(){
        return view('viw_admin_register');
    }

    public function store(Request $req){
      
        try {
            $validate = $req->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:admins,email',
                'password'=> 'required|min:6'
            ], [
                'name.required' => 'The name field is required.',
                'email.required' => 'The email field is required.',
                'email.email' => 'Please enter a valid email address.',
                'email.unique' => 'This email is already registered.',
                'password.required' => 'The password field is required.',
                'password.min' => 'The password must be at least 6 characters long.',
            ]);
    
            
            $admin = Admin::create([
                'name' => $validate['name'],
                'email' => $validate['email'],
                'password' => Hash::make($validate['password'])
            ]);
            
            return redirect()->back()->with('success', 'Admin created successfully!');
        } catch(ValidationException $e){
            return redirect()->back()->withErrors($e -> errors())->withInput();
        }


    }

    public function login(Request $req){
        $data               = $req->all();
        $json['msg_class']  = 'alert-danger';
        if(!empty($data['email']) && !empty($data['password'])){
            $admin = Admin::where('email',$data['email'])->first();
            if(!$admin || !Hash::check($data['password'],$admin->password)){
                return redirect()->back()->with('error', 'Invalid email or password.')->withInput();
            }
            session(['admin_id' => $admin->id, 'admin_name' => $admin->name]);
            return redirect()->route('dashboard');
        
        } else {
            return redirect()->back()->with([
                'class'=>'alert-danger',
                'msg'=>'Invalid username password!!!'
            ]);
        }

        echo json_encode($json);
    }

    public function logout(Request $req){
        session()->flush();
        return redirect()->route('adminlogin');
    }


    public function users(Request $req){
        $search_key = $req->get('search');
        $query = User::whereNotNull('current_board_id')
            ->join('board_members', 'board_members.user_id', '=', 'users.id')
            ->join('boards', 'boards.id', '=', 'board_members.board_id');

        if (!empty($search_key)) {
            $query->where(function($q) use ($search_key) {
                $q->where('users.name', 'like', '%' . $search_key . '%')
                ->orWhere('users.email', 'like', '%' . $search_key . '%')
                ->orWhere('users.mobile', 'like', '%' . $search_key . '%');
            });
        }

        $users = $query->select(
                'users.id',
                'users.name',
                'users.email',
                'users.mobile',
                'users.gender',
                'users.referred_by',
                'board_members.position',
                'board_members.level',
                'boards.board_name'
            )->get();
        return view('viw_admin_users', compact('users'));
    }

    public function boards(Request $req){
        $boards = BoardMember::whereNotNull('board_id')
            ->join('boards', 'board_members.board_id', '=', 'boards.id')
            ->select('board_members.board_id', 'boards.board_name as board_name')
            ->selectRaw('count(board_members.id) as total_members')
            ->groupBy('board_members.board_id', 'boards.board_name')
            ->get();

        return view('viw_admin_boards', compact('boards'));
    }

    public function board_details(Request $req,$board_id){
        $board_details = BoardMember::whereNotNull('board_id')
        ->join('users','users.id','=','board_members.user_id')
        ->join('boards','boards.id','=','board_members.board_id')
        ->select('boards.board_name','users.name','board_members.position','board_members.level')
        ->where('boards.id','=',$board_id)
        ->orderBy('board_members.position','ASC')
        ->get();
        return view('viw_admin_board_detail', compact('board_details', 'board_id'));
    }
}
