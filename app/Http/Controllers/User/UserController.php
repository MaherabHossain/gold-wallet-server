<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Auth;
class UserController extends Controller
{
    public function index(){
        $data['users'] = User::all();
         
        return view('users.index', $data);
    }
    public function create(Request $request){
        $formData['name'] = $request->name;
        $formData['nid_no'] = $request->nid_no;
        $formData['email'] = $request->email;
        $formData['password'] = Hash::make($request->password);    
        if($request->name && $request->email && $request->password&& $request->nid_no){
           if(User::create($formData)){
            return response()->json(['messsage'=>"user created successfully"],200 );
           }else{
            return response()->json(['error'=>"server side problem!"],403 );
           }
        }else{
            return response()->json(['error'=>"validation error"],400 );
        }
        
    }
    public function login(Request $request){
        $formData['email'] = $request->email;  
        $formData['password'] = $request->password;

        //  return  $request->email;
         
        if($request->email && $request->password){
        //    work here
        if(!Auth::attempt(['email'=>$formData['email'],'password'=>$formData['password']])){
            return response()->json(['error'=>"invalid credentials",],500 );
        }else{
            $user = User::where('email',$request->email)->first();
            $token = $user->createToken('authToken')->plainTextToken;
            return response()->json(['message'=>"log in successfully!",'token'=>$token,"user"=>[
                'name'=>$user->name,'email'=>$user->email
            ]],200 );


        }

        }else{
            return response()->json(['error'=>"validation error"],400 );
        }
    }

    public function delete(Request $request){
        $user = User::find($request->id);
        if( $user->delete()){
            return redirect()->back()->with('success', 'User deleted successfully');   
        }else{
            return redirect()->back()->with('error', 'Something went wrong');   
        }


    }
}
