<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

   protected $userId;
   
   /**
    * Set the user id
   */
   public function __construct(){

      $this->middleware(function ($request, $next) {
         if($request->is('profile') || $request->is('logout')){ 
            $this->userId = auth()->user()->id; 
         }
         return $next($request);
      });
   }
   
   public function login(Request $request){
      //Validate request
      $this->validate($request, [
         'email' => 'required|email',
         'password' => 'required|min:6'
      ]); 

      if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
         $user = Auth::user();
         
         return response()->json([
            'user' => [
               'name' => $user->name,
               'email' => $user->email,
               'id' => $user->id
            ]
         ]);
      } else {
         return response()->json([
            'result' => 0
         ], 401); 
      }
   }

   public function register(Request $request){
      //Validate request
      $this->validate($request, [
         'name' => 'required|min:3',
         'email' => 'required|email',
         'password' => 'required|min:6'
      ]);

      $user = new User;
      $user->fill([
         'name' => $request->input('name'),
         'email' => $request->input('email'),
         'password' => bcrypt($request->input('password')),
         'description' => ''
      ]);

      if($user->save()){ 

         //Log the user in
         if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            return response()->json([
               'error' => 0,
               'user' => [
                  'name' => $user->name,
                  'email' => $user->email,
                  'id' => $user->id
               ]
            ]);
         } else {
            return response()->json(['error' => 1, 'action'=> 'login'], 401); 
         }
      } else {
         return response()->json(['error' => 1, 'action'=> 'register'], 401); 
      }
   }

   public function updateProfile(Request $request){
      $rules = 
      [
         'name' => 'required|min:3',
         'email' => 'required|email',
      ];

      if ($request->filled('password')) {
         $rules['password'] = 'required|min:6';
      }

      //Validate request
      $this->validate($request, $rules);

      $user = User::findOrFail($this->userId);
      $user->fill([
         'name' => $request->input('name'),
         'email' => $request->input('email'),
         'description' => $request->input('description')
      ]);

      if ($request->filled('password')) {
         $user->password = bcrypt($request->input('password'));
      }

      if($user->save()){ 
         return response()->json(['error' => 0]); 
      } else {
         return response()->json(['error' => 1], 401); 
      }
   }

   public function retrieveProfile(Request $request){ 
      $user = User::findOrFail($this->userId);
      return response()->json([
         'error' => 0,
         'user' => [
            'name' => $user->name,
            'email' => $user->email,
            'id' => $user->id,
            'description' => $user->description,
         ]
      ]);
   }

   public function logout(Request $request){
      Auth::logout();
      $request->session()->invalidate();
      $request->session()->regenerateToken();
      //return redirect('/');
      return response()->json(['error' => 0]); 
   }
}