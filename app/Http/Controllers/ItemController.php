<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;


class ItemController extends Controller
{
    public function item_view()
    {
        try {
            $data = Http::withHeaders(
                [
                    'Authorization' => 'Bearer ' . Session::get('token'),
                    'api_key' => config('app.api_key')
                ]
            )->get(config('app.api_host') . '/api/v1/item/get_items');

            $data  = json_decode($data);

            if ($data) {
                $message = $data->response->code->message;
                if ($data->response->code->key != 101) {
                    return back();
                } else {
                    $response = $data->response->item;
                    // dd($data);
                    return view('item.index', compact('response'));
                }
            } else {
                return back();
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    //add
    public function item_add_view()
    {
        try {
            return view('item.add');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function item_add(Request $request)
    {
        try {
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
                    "is_not_return" => $request->is_not_return,
                    "tag" => []
                ]
            ]);

            $data  = json_decode($data);
            // dd($data);
            if ($data) {
                $message = $data->response->code->message;
                if ($data->response->code->key != 101) {
                    return view('item.add', compact('message'));
                } else {
                    // sleep(2);
                    return redirect()->route('item_view');
                }
            } else {
                return back();
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    //stock
    public function item_add_stock_view($id)
    {
        try {
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
                    return view('item.item', compact('message'));
                } else {
                    $response = $data->response->item;
                    // dd($response);
                    return view('item.addStock', compact('response'));
                }
            } else {
                return back();
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function item_add_stock(Request $request)
    {
        try {
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
                $message = $data->response->code->message;

                if ($data->response->code->key != 101) {
                    return view('item.index', compact('message'));
                } else {
                    return redirect()->route('item_view');
                }
            } else {
                return back();
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    //edit
    public function item_edit_view($id)
    {
        try {
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
                    return view('item.edit', compact('message'));
                } else {
                    $response = $data->response->item;
                    // dd($response);
                    return view('item.edit', compact('response'));
                }
            } else {
                return back();
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function item_edit(Request $request)
    {
        try {
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
                $message = $data->response->code->message;

                if ($data->response->code->key != 101) {
                    return redirect()->route('item_view')->compact('message');
                } else {
                    return redirect()->route('item_view');
                }
            } else {
                return back();
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
