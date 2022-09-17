<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function register_view()
    {

        return view('auth.register');
    }

    public function register(Request $request)
    {
        // dd($request->name, $request->email, $request->password, $request->password_confirmation,);
        $data = Http::withHeaders(
            ['api_key' => config('app.api_key')]
        )->post(config('app.api_host') . '/api/v1/auth/register', [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'password_confirmation' => $request->password_confirmation,
        ]);

        $data  = json_decode($data);

        if ($data->response->code->key != 101) {
            $message = $data->response->code->message;
            // dd($message);
            return view('auth.register', compact('message'));
        }

        return view('auth.login');
    }

    public function login_view()
    {

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $data = Http::withHeaders(
            ['api_key' => config('app.api_key')]
        )->post(config('app.api_host') . '/api/v1/auth/login', [
            'email' => $request->email,
            'password' => $request->password
        ]);

        $data  = json_decode($data);

        if ($data->response->code->key != 101) {
            $message = $data->response->code->message;
            // dd($message);
            return view('auth.login', compact('message'));
        }

        Session::put('token', $data->response->token);

        $datarole = Http::withHeaders([
            'Authorization' => 'Bearer ' . Session::get('token'),
            'api_key' => config('app.api_key')
        ])->get(config('app.api_host') . '/api/v1/user/get_current');

        $dataroles  = json_decode($datarole);
        // dd($dataroles->response->user->roles);
        foreach ($dataroles->response->user->roles as $value) {
            if ($value->name === 'staff') {
                Session::put('staff', 'true');
            }
            if ($value->name === 'owner') {
                Session::put('owner', 'true');
            }
        }
        // dd(Session::get('owner'), Session::get('staff'));
        Session::get('token');

        return redirect()->route('home');
    }

    public function logout()
    {
        Session::forget('token');
        Session::forget('owner');
        Session::forget('staff');
        return redirect('/');
    }
}
