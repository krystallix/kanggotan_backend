<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
        $users = User::with('roles')->get();
        return $this->ok($users,"Success");
    }
    public function roles(){
        $roles = Role::all();
        return $this->ok($roles, "Success");
    }

    public function createUser(Request $request){
        $user = User::Create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'status' => 'ACTIVE',
            'password' => Hash::make($request->password)
        ]);
        $user->assignRole($request->role);
        if(!$user){
            return $this->error("Error");
        }
        return $this->ok($user,"Sukses");
    }
    public function deleteUser($id){
        $user = User::find($id);
        if($user->delete()){
            return $this->ok($user,"Sukses");
        }else{
            return $this->error("Error");
        }
    }
}
