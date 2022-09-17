<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function order_view()
    {
        $user = Http::withHeaders(
            [
                'Authorization' => 'Bearer ' . Session::get('token'),
                'api_key' => config('app.api_key')
            ]
        )->get(config('app.api_host') . '/api/v1/user/get_current');
        $user  = json_decode($user);

        $data = Http::withHeaders(
            [
                'Authorization' => 'Bearer ' . Session::get('token'),
                'api_key' => config('app.api_key')
            ]
        )->get(config('app.api_host') . '/api/v1/booking/get_bookings', [
            "filter" => [
                "users_id" => $user->response->user->id,
            ]
        ]);

        $data  = json_decode($data);

        $response = $data->response->booking;


        return view('order.index', compact('response'));
    }

    public function order_item_view($id)
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
        // dd($response = $data->response->booking);
        return view('order.view', compact('response'));
    }

    public function order_add_view($id)
    {
        $data = Http::withHeaders(
            [
                'Authorization' => 'Bearer ' . Session::get('token'),
                'api_key' => config('app.api_key')
            ]
        )->get(config('app.api_host') . '/api/v1/item/get_items', [
            "filter" => [
                "is_active" => 1,
                "greater_amount" => 1
            ]
        ]);

        $data  = json_decode($data);

        $response = $data->response->item;
        $bookingid = $id;
        // dd($response);

        $booking = Http::withHeaders(
            [
                'Authorization' => 'Bearer ' . Session::get('token'),
                'api_key' => config('app.api_key')
            ]
        )->get(config('app.api_host') . '/api/v1/booking/get_bookings', [
            "filter" => [
                "booking_id" => $id,
            ]
        ]);

        $booking  = json_decode($booking);

        foreach ($booking->response->booking[0]->booking_item as $key => $value) {
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
            $booking->response->booking[0]->booking_item[$key]->name = $item->response->item[0]->name;
        }

        $booking = $booking->response->booking[0];

        return view('order.view_add', compact('response', 'bookingid', 'booking'));
    }

    public function order_item_add_view(Request $request)
    {
        // dd($request->bookingid, $request->id);
        $data = Http::withHeaders(
            [
                'Authorization' => 'Bearer ' . Session::get('token'),
                'api_key' => config('app.api_key')
            ]
        )->get(config('app.api_host') . '/api/v1/item/get_items', [
            "filter" => [
                "item_id" => $request->id
            ]
        ]);
        $data  = json_decode($data);
        $response = $data->response->item;
        $bookingid = $request->bookingid;

        // return redirect()->route('order_item_add_view');
        return view('order.add_item_booking', compact('response', 'bookingid'));
    }

    public function order_item_add(Request $request)
    {
        // dd($request->bookingid, $request->id, $request->amount, $request->note);
        $booking_item["booking_id"] = $request->bookingid;
        $booking_item["item_id"] = $request->id;
        $booking_item["note_user"] = (!$request->note) ? "ยืม" : $request->note;
        $booking_item["amount"] = $request->amount;
        // dd($booking_item["note_user"]);
        $data = Http::withHeaders(
            [
                'Authorization' => 'Bearer ' . Session::get('token'),
                'api_key' => config('app.api_key')
            ]
        )->post(config('app.api_host') . '/api/v1/booking/add_items', [
            "booking_item" => [$booking_item]
        ]);
        $data  = json_decode($data);

        if ($data) {
            $message = $data->response->code->message;
            if ($data->response->code->key != 101) {
                return redirect()->route('order_view', compact('message'));
                // return redirect()->route('order_item_add_view', ["id" => $request->id, "bookingid" => $request->bookingid]);
                // return $this->order_add_view($request->bookingid);
            }
        }
        $request->id = $request->bookingid;
        // dd($request);

        // dd($data->response);
        // return redirect()->route('order_view');
        return  $this->order_item_view($request);
        // return redirect()->back();
        // return redirect()->url('order/add/item/' . $request->bookingid);
    }

    public function order_confirm(Request $request)
    {
        $booking = Http::withHeaders(
            [
                'Authorization' => 'Bearer ' . Session::get('token'),
                'api_key' => config('app.api_key')
            ]
        )->get(config('app.api_host') . '/api/v1/booking/get_bookings', [
            "filter" => [
                "booking_id" => $request->id
            ]
        ]);
        $booking  = json_decode($booking);
        $bookingresponse = $booking->response->booking[0]->booking_item;
        // dd($bookingresponse);

        if (!$bookingresponse) {
            $message = 'ยังไม่ได้เพื่มของ';
            return redirect()->route('order_view', compact('message'));
        }
        // dd($request->id, $request->start_date, $request->end_date);
        $data = Http::withHeaders(
            [
                'Authorization' => 'Bearer ' . Session::get('token'),
                'api_key' => config('app.api_key')
            ]
        )->patch(config('app.api_host') . '/api/v1/booking/update_booking', [
            "booking" => [
                "id" => $request->id,
                "store_id" => 1,
                "status_id" => 2,
                "start_date" => $request->start_date,
                "end_date" => $request->end_date,
            ]
        ]);
        $data  = json_decode($data);
        // dd($data->response);
        return redirect()->route('order_view');
        // return  redirect()->previous();
    }

    public function order_edit_booking_view($id)
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
        $data->response->booking[0]->start_date = date("Y-m-d\TH:i", strtotime($data->response->booking[0]->start_date));
        $data->response->booking[0]->end_date = date("Y-m-d\TH:i", strtotime($data->response->booking[0]->end_date));

        // dd($response = $data->response->booking);
        return view('order.edit_booking', compact('response'));
    }
    public function order_edit_booking(Request $request)
    {
        // dd($request->id, $request->start_date, $request->end_date);
        $data = Http::withHeaders(
            [
                'Authorization' => 'Bearer ' . Session::get('token'),
                'api_key' => config('app.api_key')
            ]
        )->patch(config('app.api_host') . '/api/v1/booking/update_booking', [
            "booking" => [
                "id" => $request->id,
                "store_id" => 1,
                "status_id" => 1,
                "start_date" =>  date("Y-m-d H:i:s", strtotime($request->start_date)),
                "end_date" => date("Y-m-d H:i:s", strtotime($request->end_date)),
            ]
        ]);
        $data  = json_decode($data);
        // dd($data->response);
        return $this->order_item_view($request->id);
        // return redirect()->route('order_view');
    }
}
