<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Contracts\Auth\Guard;
//use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\Http\Requests\RegRequest;
use App\Http\Requests\LoginRequest;
use Hash;
use Auth;
use Request;
class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';
    protected $loginPath = '/login'; 
    protected $redirectPath = '/'; 
    public $auth;


    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
        //$this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * function: get create new account
     */
    public function getRegister(){
        return view('auth.register');
    }
    public function postRegister(RegRequest $request){
        $user = new User;
        $user->username = $request->username;
        $user->fullname = $request->fullname;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = 1;
        $user->avatar = 'noavatar.png';
        $user->remember_token = $request->_token;
        $user->save();
        return redirect()->route('getReg')->with(['content'=>'Register Successfully!', 'level'=>'success']);

    }
    /**
     * function: get login
     */
    public function getLogin(){
        if(!Auth::check()){
            return view('auth.login');
        }else{
            return redirect()->route('index');
        }
        
    }
    /**
     * function: post Login
     */
    public function postLogin(LoginRequest $request){

        $userLogin = array(
            'username' => $request->username,
            'password' => $request->password,
            'role' => 1,
        );
        $remember = $request->remember ? true : false; 
        if(Auth::attempt($userLogin, $remember)){
            return redirect()->route('index');
        }else{
            return redirect()->back()->withErrors(['content'=>'Username or password Invalid!']);
        }
    }
    /**
     * function logout
     */
    public function logout(){
        if(Auth::check()){
            Auth::logout();
        }
        return redirect()->route('index');
    }
    /**
     * function: get profile acconnt
     */
    public function profile($username){
        $user = User::where('username', $username)->first();
        if(empty($user)){
            return redirect()->route('404');
        }
        return view('auth.profile', ['profile' => $user->toArray()]);
    }
    /**
     * function: change Avatar account
     */
    public function changeAvatar(){
        $data = array();
        if(Request::ajax()){
            if(Request::hasFile('avatar')){

                $file = Request::file('avatar');
                $userid = Request::get('userid');
                $user = User::find($userid);
                $current_avatar = $user->avatar;
                $imgExt = $file->getClientOriginalExtension();
                $filename = "IES-".time().".".$imgExt;
                $result = $file->move(base_path().'/public/uploads/', $filename);
                $user->avatar = $filename;
                $user->save();
                if($current_avatar != 'noavatar.png' ){
                    \File::delete(public_path()."/uploads/".$current_avatar);
                }
                $data['status'] = 'success';
                $data['msg'] = "change avatar successfully!!!";

            }else{
                $data['status'] = 'error';
                $data['msg'] = "Please choose an avatar!!!";

            }
        }
        return response()->json($data);
    }
    /**
     * function change fullname 
     */
    public function changeFullname(){
        $data = array('status' => '', 'msg' => 'Errors!!!');
        if(Request::ajax()){
            $userid = Request::get('userid');
            $fullname = Request::get('fullname');
             //validte
            $validate = Validator::make(Request::all(), [
                    'fullname' => 'required'
                ], [
                    'fullname.required' => 'Please enter fullname!!!',

                ]);
            if($validate->fails()){
                $data['status'] = 'error';
                $data['msg'] = $validate->errors()->all();
                return response()->json($data);
            }
            $user = User::find($userid);
            $user->fullname = $fullname;
            $user->save();
            $data['status'] = 'success';
            $data['msg'] = "Change fullname successfully!!!";
        }
        return response()->json($data);
    }
    /**
     * function change email
     */
    public function changeEmail(){
        $data = array('status' => '', 'msg' => 'Errors!!!');
        if(Request::ajax()){
            $userid = Request::get('userid');
            $email = Request::get('email');
            //validte
            $validate = Validator::make(Request::all(), [
                    'email' => 'email|unique:users,email'
                ], [
                    'email.email' => 'Not an email!!!',
                    'email.unique' => 'This email really exists, please enter other email!!!'

                ]);
            if($validate->fails()){
                $data['status'] = 'error';
                $data['msg'] = $validate->errors()->all();
                return response()->json($data);
            }
            $user = User::find($userid);
            $user->email = $email;
            $user->save();
            $data['status'] = 'success';
            $data['msg'] = "Change email successfully!!!";
        }
        return response()->json($data);
    }
}
