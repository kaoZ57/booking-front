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
        // dd($data->response->user);

        foreach ($data->response->user as $key => $value) {
            $staff_data = Http::withHeaders([
                'Authorization' => 'Bearer ' . Session::get('token'),
                'api_key' => config('app.api_key')
            ])->get(config('app.api_host') . '/api/v1/user/get_current', [
                "filter" => [
                    "user_id" => $value->id
                ]
            ]);

            $staff_data  = json_decode($staff_data);
            $data->response->user[$key]->is_staff = "false";

            foreach ($staff_data->response->user->roles as $value) {
                if ($value->name == 'staff') {
                    $data->response->user[$key]->is_staff = "true";
                }
            }
        }

        // dd($data);
        if ($data) {
            $message = $data->response->code->message;
            if ($data->response->code->key != 101) {
                return back();
            } else {
                $response = $data->response->user;
                // dd($data->response->user);s
                return view('dashboard.index', compact('response'));
            }
        } else {
            return back();
        }
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
        Session::put('staff', 'true');
        if ($data) {
            $message = $data->response->code->message;
            if ($data->response->code->key != 101) {
                return back();
            } else {
                return back();
            }
        } else {
            return back();
        }
    }
}
