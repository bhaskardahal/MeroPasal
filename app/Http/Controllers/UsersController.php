<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use Session;
use App\Country;

class UsersController extends Controller
{
    public function register(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
//            check if users is already exist in our database
            $usersCount = User::where('email' , $data['email'])->count();
            if($usersCount > 0){
                return redirect()->back()->with('flash_message_error', 'Email Already Exists');
            } 
            else {
                $user = new User;
                $user->name = ucwords(strtolower($data['name']));
                $user->email = strtolower($data['email']);
                $user->password = bcrypt($data['password']);
                $user->admin = "0";
                $user->save();

                if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']])){
                    Session::put('frontSession', $data['email']);
                    return redirect()->route('cart');
                }
            }
        }
        return view ('frontend.users.login_register');
    }
    
    public function userlogout(){
        Auth::logout();
        Session::forget('frontSession');
        return redirect('/');
    }
    
    public function userLogin(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']])){
                Session::put('frontSession', $data['email']);
                return redirect()->route('cart');
            } else {
                return redirect()->back()->with('flash_message_error', 'Invalid Username Solti');
            }
        }
    }
    public function account(Request $request){
      $countries = Country::all();
      $user_id = Auth::user()->id;
      $userDetails = User::find($user_id);
      if($request->isMethod('post')){
            $data = $request->all();
            $user = User::find($user_id);
            if(empty($data['name'])){
                return redirect()->back()->with('flash_message_error', 'Name is Required');
            }
            if(empty($data['address'])){
                $data['address'] = "";
            }
            if(empty($data['city'])){
                $data['city'] = "";
            }
            if(empty($data['state'])){
                $data['state'] = "";
            }
            $user->name = $data['name'];
            $user->address = $data['address'];
            $user->city = $data['city'];
            $user->state = $data['state'];
            $user->country = $data['country'];
            $user->pincode = $data['pincode'];
            $user->mobile = $data['mobile'];
            $user->save();
            return redirect()->back()->with('flash_message_success', 'Account Updated Successfully');
        }
      return view ('frontend.users.account', compact('user_id', 'userDetails', 'countries'));
    }

}
