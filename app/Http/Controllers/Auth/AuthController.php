<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class AuthController extends Controller
{
    public function register_view()
    {


        return view('auth.register');
    }

    public function register(Request $request)
    {
        Session::forget('token');
        Session::forget('owner');
        Session::forget('staff');
        Session::forget('name');
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
        Session::forget('token');
        Session::forget('owner');
        Session::forget('staff');
        Session::forget('name');
        $data = Http::withHeaders(
            ['api_key' => config('app.api_key')]
        )->post(config('app.api_host') . '/api/v1/auth/login', [
            'email' => $request->email,
            'password' => $request->password
        ]);

        $data  = json_decode($data);
        // dd($data);
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
        // Session::get('token');
        Session::put('name', $dataroles->response->user->name);

        return redirect()->route('home');
    }

    public function logout()
    {
        Session::forget('token');
        Session::forget('owner');
        Session::forget('staff');
        Session::forget('name');
        return redirect('/');
    }

    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }
    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {

        $user = Socialite::driver('google')->user();
        // dd($user);

        $data = Http::withHeaders(
            ['api_key' => config('app.api_key')]
        )->post(config('app.api_host') . '/api/v1/auth/login', [
            'email' => $user->email,
            'password' => $user->id
        ]);

        $data  = json_decode($data);

        // dd($data);
        // dd($data->response->code->key == 101);

        if ($data) {
            if ($data->response->code->key == 101) {

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

                Session::put('name', $user->name);

                return redirect()->route('home');
            } else {
                $register = Http::withHeaders(
                    ['api_key' => config('app.api_key')]
                )->post(config('app.api_host') . '/api/v1/auth/register', [
                    'name' => $user->name,
                    'email' => $user->email,
                    'password' => $user->id,
                    'password_confirmation' => $user->id,
                ]);
                $register  = json_decode($register);
                // dd($register->response->code->key);

                if ($register->response->code->key != 101) {
                    $message = $register->response->code->message;
                    // dd($message);
                    return view('auth.register', compact('message'));
                }

                $data = Http::withHeaders(
                    ['api_key' => config('app.api_key')]
                )->post(config('app.api_host') . '/api/v1/auth/login', [
                    'email' => $user->email,
                    'password' => $user->id
                ]);

                $data  = json_decode($data);
                // dd($data);

                Session::put('token', $data->response->token);
                Session::put('name', $user->name);

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

                return redirect()->route('home');
            }
        } else {
            return back();
        }
    }
}
