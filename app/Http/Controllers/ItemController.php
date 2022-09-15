<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;


class ItemController extends Controller
{
    public function item_view()
    {
        $data = Http::withHeaders(
            [
                'Authorization' => 'Bearer ' . Session::get('token'),
                'api_key' => config('app.api_key')
            ]
        )->get(config('app.api_host') . '/api/v1/item/get_items');

        $data  = json_decode($data);

        if ($data) {
            $massage = $data->response->code->message;
            if ($data->response->code->key != 101) {
                return redirect()->route('home');
            }
        }

        $response = $data->response->item;
        // dd($data);
        return view('item.index', compact('response'));
    }

    //add
    public function item_add_view()
    {
        return view('item.add');
    }

    public function item_add(Request $request)
    {
        // dd($request->name, $request->description, $request->is_active, $request->is_not_return);
        $data = Http::withHeaders(
            [
                'Authorization' => 'Bearer ' . Session::get('token'),
                'api_key' => config('app.api_key')
            ]
        )->post(config('app.api_host') . '/api/v1/item/create_item', [
            "item" => [
                "name" => $request->name,
                "description" => $request->description,
                "store_id" => 1,
                "is_active" => $request->is_active,
                "is_not_return" => 0,
                "tag" => []
            ]
        ]);

        $data  = json_decode($data);
        // dd($data);
        if ($data) {
            $massage = $data->response->code->message;

            if ($data->response->code->key != 101) {
                return view('item.add', compact('massage'));
            }
        }

        return redirect()->route('item_view');
    }

    //stock
    public function item_add_stock_view($id)
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
            $massage = $data->response->code->message;

            if ($data->response->code->key != 101) {
                return view('item.item', compact('massage'));
            }
        }

        $response = $data->response->item;
        // dd($response);
        return view('item.addStock', compact('response'));
    }

    public function item_add_stock(Request $request)
    {
        $data = Http::withHeaders(
            [
                'Authorization' => 'Bearer ' . Session::get('token'),
                'api_key' => config('app.api_key')
            ]
        )->post(config('app.api_host') . '/api/v1/stock/add_item_to_stock', [
            "stock" => [
                "item_id" => $request->id,
                "amount" => $request->amount,
            ]
        ]);

        $data  = json_decode($data);
        if ($data) {
            $massage = $data->response->code->message;

            if ($data->response->code->key != 101) {
                return view('item.index', compact('massage'));
            }
        }

        return redirect()->route('item_view');
    }

    //edit
    public function item_edit_view($id)
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
            $massage = $data->response->code->message;

            if ($data->response->code->key != 101) {
                return view('item.edit', compact('massage'));
            }
        }

        $response = $data->response->item;
        // dd($response);
        return view('item.edit', compact('response'));
    }

    public function item_edit(Request $request)
    {
        // dd($request->id, $request->name, $request->description, $request->is_active, $request->is_not_return);
        $data = Http::withHeaders(
            [
                'Authorization' => 'Bearer ' . Session::get('token'),
                'api_key' => config('app.api_key')
            ]
        )->patch(config('app.api_host') . '/api/v1/item/update_item', [
            "item" => [
                "id" => $request->id,
                "name" => $request->name,
                "description" => $request->description,
                "store_id" => 1,
                "is_active" => $request->is_active,
                "is_not_return" => $request->is_not_return,
                "tag" => []
            ]
        ]);

        $data  = json_decode($data);
        if ($data) {
            $massage = $data->response->code->message;

            if ($data->response->code->key != 101) {
                return redirect()->route('item_view')->compact('massage');
            }
        }

        return redirect()->route('item_view');
    }
}
