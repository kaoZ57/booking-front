<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;


class ConfirmController extends Controller
{
    public function confirm_view()
    {
        $data = Http::withHeaders(
            [
                'Authorization' => 'Bearer ' . Session::get('token'),
                'api_key' => config('app.api_key')
            ]
        )->get(config('app.api_host') . '/api/v1/booking/get_bookings');

        $data  = json_decode($data);
        // dd($data->response);

        if ($data) {
            $massage = $data->response->code->message;
            if ($data->response->code->key != 101) {
                return redirect()->route('home');
            }
        }
        // dd($data->response->booking[0]->booking_item);


        foreach ($data->response->booking as $key => $value) {
            $users = Http::withHeaders(
                [
                    'Authorization' => 'Bearer ' . Session::get('token'),
                    'api_key' => config('app.api_key')
                ]
            )->get(config('app.api_host') . '/api/v1/user/get_all', [
                "filter" => [
                    "user_id" => $value->users_id
                ]
            ]);
            $users  = json_decode($users);
            // dd($data->response->booking[$key]);
            $data->response->booking[$key]->name = $users->response->user[0]->name;
        }

        $response = $data->response->booking;
        // dd($response);

        return view('booking_confirm.index', compact('response'));
    }

    public function confirm_view_item($id)
    {
        $data = Http::withHeaders(
            [
                'Authorization' => 'Bearer ' . Session::get('token'),
                'api_key' => config('app.api_key')
            ]
        )->get(config('app.api_host') . '/api/v1/booking/get_bookings', [
            "filter" => [
                "booking_id" => $id,
            ]
        ]);

        $data  = json_decode($data);

        foreach ($data->response->booking[0]->booking_item as $key => $value) {
            $item = Http::withHeaders(
                [
                    'Authorization' => 'Bearer ' . Session::get('token'),
                    'api_key' => config('app.api_key')
                ]
            )->get(config('app.api_host') . '/api/v1/item/get_items', [
                "filter" => [
                    "item_id" => $value->item_id
                ]
            ]);
            $item  = json_decode($item);
            // dd($data->response->booking[0]->booking_item);
            $data->response->booking[0]->booking_item[$key]->name = $item->response->item[0]->name;
        }

        $response = $data->response->booking[0];

        return view('booking_confirm.view_item', compact('response'));
    }

    function confirm_status(Request $request)
    {
        // dd($request->id, $request->status_id);

        $data = Http::withHeaders(
            [
                'Authorization' => 'Bearer ' . Session::get('token'),
                'api_key' => config('app.api_key')
            ]
        )->get(config('app.api_host') . '/api/v1/booking/get_bookings', [
            "filter" => [
                "booking_id" => $request->id,
            ]
        ]);

        $data  = json_decode($data);
        // dd($data->response->booking[0]->booking_item);

        $booking = array();
        foreach ($data->response->booking[0]->booking_item as $key => $value) {
            $data->response->booking[0]->booking_item[$key]->status_id = $data->response->booking[0]->booking_item[$key]->status_id + 1;
            $data->response->booking[0]->booking_item[$key]->note_owner = 'ให้ยืม';
        }

        // dd($data->response->booking[0]->booking_item);

        $booking_item  = Http::withHeaders(
            [
                'Authorization' => 'Bearer ' . Session::get('token'),
                'api_key' => config('app.api_key')
            ]
        )->patch(config('app.api_host') . '/api/v1/booking/update_items_by_staff', [
            "booking_item" => $data->response->booking[0]->booking_item
        ]);
        $booking_item = json_decode($booking_item);
        // dd($booking_item);

        $massage = $data->response->code->message;
        if ($booking_item) {
            if ($booking_item->response->code->key != 101) {
                return redirect()->route('confirm_view', compact('massage'));
            }
        }


        return redirect()->route('confirm_view', compact('massage'));
    }

    function confirm_reject(Request $request)
    {
        // dd($request->id, $request->status_id);

        $data = Http::withHeaders(
            [
                'Authorization' => 'Bearer ' . Session::get('token'),
                'api_key' => config('app.api_key')
            ]
        )->get(config('app.api_host') . '/api/v1/booking/get_bookings', [
            "filter" => [
                "booking_id" => $request->id,
            ]
        ]);

        $data  = json_decode($data);
        // dd($data->response->booking[0]->booking_item[0]->status_id);

        foreach ($data->response->booking[0]->booking_item as $key => $value) {
            $data->response->booking[0]->booking_item[$key]->status_id = 5;
            $data->response->booking[0]->booking_item[$key]->note_owner = 'ไม่ให้ยืม';
        }
        // dd($data->response->booking[0]->booking_item);
        $booking_item  = Http::withHeaders(
            [
                'Authorization' => 'Bearer ' . Session::get('token'),
                'api_key' => config('app.api_key')
            ]
        )->patch(config('app.api_host') . '/api/v1/booking/update_items_by_staff', [
            "booking_item" => $data->response->booking[0]->booking_item
        ]);
        $booking_item = json_decode($booking_item);


        // dd($data);
        // dd($booking_item->response);
        $massage = $data->response->code->message;
        if ($booking_item) {
            if ($booking_item->response->code->key != 101) {
                return redirect()->route('confirm_view', compact('massage'));
            }
        }

        return redirect()->route('confirm_view', compact('massage'));
    }
}
