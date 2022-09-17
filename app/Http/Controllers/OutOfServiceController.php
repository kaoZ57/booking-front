<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class OutOfServiceController extends Controller
{
    public function outOfService_view()
    {
        $data = Http::withHeaders(
            [
                'Authorization' => 'Bearer ' . Session::get('token'),
                'api_key' => config('app.api_key')
            ]
        )->get(config('app.api_host') . '/api/v1/out_of_service/get_all', [
            "filter" => [
                "ready_to_use" => 0
            ]
        ]);

        $data  = json_decode($data);

        // $response = array();
        foreach ($data->response->out_of_service as $key => $value) {
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
            $data->response->out_of_service[$key]->name = $item->response->item[0]->name;
            // dd($data->response->out_of_service[$key]);
        }
        // dd($data);

        if ($data) {
            $message = $data->response->code->message;
            if ($data->response->code->key != 101) {
                return redirect()->route('item_view');
            }
        }

        $response = $data->response->out_of_service;

        return view('out_of_service.index', compact('response'));
    }
    public function outOfService_add_view($id)
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
        // dd($data);

        if ($data) {
            $message = $data->response->code->message;
            if ($data->response->code->key != 101) {
                return redirect()->route('item_view');
            }
        }

        $response = $data->response->item;

        return view('out_of_service.add', compact('response'));
    }

    public function outOfService_add(Request $request)
    {
        $note = ($request->note == null) ? "ซ่อม" : $request->note;
        $data = Http::withHeaders(
            [
                'Authorization' => 'Bearer ' . Session::get('token'),
                'api_key' => config('app.api_key')
            ]
        )->post(config('app.api_host') . '/api/v1/out_of_service/add_item', [
            "out_of_service" => [
                "item_id" => $request->id,
                "note" => $note,
                "amount" => $request->amount,
            ]
        ]);
        $data  = json_decode($data);

        return redirect()->route('outOfService_view');
    }

    public function outOfService_edit(Request $request)
    {
        $data = Http::withHeaders(
            [
                'Authorization' => 'Bearer ' . Session::get('token'),
                'api_key' => config('app.api_key')
            ]
        )->patch(config('app.api_host') . '/api/v1/out_of_service/update', [
            "out_of_service" => [
                "id" => $request->id,
                "ready_to_use" => 1,
            ]
        ]);

        return redirect()->route('item_view');
    }
}
