<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:8',
            'hectares' => 'integer',
        ]);
        $user = User::where('email', $request['email'])->first();
        if (!empty($user)) {
            return response()->json([ 'status' => 0, 'text' => 'Пользователь с почтой '.$request['email'].' уже существует' ], 200);
        }

        // Проверка телефона
        $user = User::where('phone', $request['phone'])->first();
        if (!empty($user)) {
            return response()->json([ 'status' => 0, 'text' => 'Пользователь с телефоном '.$request['phone'].' уже существует' ], 200);
        }
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'ga' => $request->hectares,
            'verified' => 1,
            'role_id'  => 3
        ]);
        $token = $user->createToken('jm')->accessToken;
        return response()->json(['token' => $token,'status'=>200], 200);
    }

    public function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        if (auth()->attempt($data)) {
            $token = auth()->user()->createToken('jm')->accessToken;
            return response()->json(['token' => $token,'user_id'=>auth()->user()->id,'role_id'=>auth()->user()->role_id ,'status'=>200], 200);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

    public function logout(Request $request){
        $accessToken = Auth::user()->token();
        $token= $request->user()->tokens->find($accessToken);
        $token->revoke();
        $response=array();
        $response['status']=200;
        $response['msg']="Successfully logout";
        return response()->json($response)->header('Content-Type', 'application/json');
    }
}
