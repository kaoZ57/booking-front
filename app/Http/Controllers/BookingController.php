<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class BookingController extends Controller
{
    public function booking_view()
    {

        $data = Http::withHeaders(
            [
                'Authorization' => 'Bearer ' . Session::get('token'),
                'api_key' => config('app.api_key')
            ]
        )->get(config('app.api_host') . '/api/v1/item/get_items', [
            "filter" => [
                "is_active" => 1
            ]
        ]);

        $data  = json_decode($data);

        if ($data) {
            $message = $data->response->code->message;
            if ($data->response->code->key != 101) {
                return redirect()->route('home');
            }
        }

        $response = $data->response->item;
        // dd($data);
        return view('booking.index', compact('response'));
    }

    public function booking_add_view($id)
    {

        $data = Http::withHeaders(
            [
                'Authorization' => 'Bearer ' . Session::get('token'),
                'api_key' => config('app.api_key')
            ]
        )->get(config('app.api_host') . '/api/v1/item/get_items', [
            "filter" => [
                "item_id" => $id
            ]
        ]);

        $data  = json_decode($data);

        if ($data) {
            $message = $data->response->code->message;
            if ($data->response->code->key != 101) {
                return redirect()->route('home');
            }
        }

        $response = $data->response->item;
        // dd($response);
        return view('booking.add', compact('response'));
    }

    public function booking_add(Request $request)
    {
        // dd($request->start_date, $request->end_date);
        // dd(date("Y-m-d H:i:s", strtotime($request->start_date)));
        $data = Http::withHeaders(
            [
                'Authorization' => 'Bearer ' . Session::get('token'),
                'api_key' => config('app.api_key')
            ]
        )->post(config('app.api_host') . '/api/v1/booking/create_booking', [
            "booking" => [
                "store_id" => 1,
                "start_date" => date("Y-m-d H:i:s", strtotime($request->start_date)),
                "end_date" => date("Y-m-d H:i:s", strtotime($request->end_date)),
                "booking_item" => []
            ]
        ]);

        $data  = json_decode($data);
        if ($data) {
            $message = $data->response->code->message;
            if ($data->response->code->key != 101) {
                return redirect()->route('booking_view', compact('message'));
            }
        }

        // return redirect()->route('order_view');
        return redirect()->route('order_view');
    }
}
