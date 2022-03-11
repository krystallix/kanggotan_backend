<?php
namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Api\Auth\RegisterRequest;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->with('roles')->first();

        if (! $user) {
            return $this->error('Akun tidak ditemukan', 422, ['email' => ['Akun tidak ditemukan']]);
        }if (!$user->status == 'BLOCKED') {
            return $this->error('Akun diblokir', 422, ['email' => ['Akun diblokir']]);
        }elseif (! Hash::check($request->input('password'), $user->password)) {
            return $this->error('Password Salah', 422, ['password' => ['Password salah']]);
        }

        $user->tokens()->delete();
        
        $token = $user->createToken('android')->plainTextToken;

        return $this->ok(['token' => $token, 'user' => $user]);
    }

    public function logout()
    {
        $user->tokens()->delete();
        
        return $this->ok([]);
    }

    public function register(RegisterRequest $request)
    {
        try {
            DB::beginTransaction();

            $user = User::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'phone' => $request->get('phone'),
                'password' => Hash::make($request->get('password')),
                'status' => 'ACTIVE'
            ]);
            //return json_encode($user);
            $user->assignRole('User');
            $token = $user->createToken('frontend')->plainTextToken;

        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->error('Terjadi Masalah, Silahkan Coba Lagi Nanti', $th);
        }
        DB::commit();

        try {
            $user->notify(new Activation($user));
        } catch (\Throwable $th) {
            //throw $th;
        }
        
        return $this->ok(['token' => $token, 'user' => $user], 'Berhasil Mendaftar');
    }


    public function getAuthenticatedUser()
    {
        $user = auth()->user();
        
        return $this->ok(['user' => $user], 'Berhasil mengambil data user');
    }

    public function requestNewVerifyToken()
    {
        try {
            $token = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,6);
            $user = User::where('id', auth()->user()->id)->first();
            $user->activation_token = $token;
            $user->save();
            $user->notify(new Activation($user));
            return $this->ok([], 'Kode aktivasi telah dikirim ke email Anda');
        } catch (\Throwable $th) {
            return $this->error('Gagal mengirim token', 500);
        }
    }
}