<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function dashboard_view()
    {
        $data = Http::withHeaders(
            [
                'Authorization' => 'Bearer ' . Session::get('token'),
                'api_key' => config('app.api_key')
            ]
        )->get(config('app.api_host') . '/api/v1/user/get_all');
        $data  = json_decode($data);

        if ($data->response->code->key != 101) {
            return HomeController::home_view();
        }

        $response = $data->response->user;
        // dd($data->response->user);

        return view('dashboard.index', compact('response'));
    }

    public function dashboard_add_staff(Request $request)
    {
        $data = Http::withHeaders(
            [
                'Authorization' => 'Bearer ' . Session::get('token'),
                'api_key' => config('app.api_key')
            ]
        )->post(config('app.api_host') . '/api/v1/user/assign_staff', [
            "user_id" => $request->user_id
        ]);
        $data  = json_decode($data);
        // dd($data->response);

        if ($data->response->code->key == 211) {
            return $this->dashboard_view();
        } elseif ($data->response->code->key != 101) {
            return redirect()->route('home');
        } else {
            return $this->dashboard_view();
        }
    }
}
