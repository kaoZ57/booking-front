<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public static function home_view()
    {
        $storedata = Http::withHeaders(
            [
                'Authorization' => 'Bearer ' . Session::get('token'),
                'api_key' => config('app.api_key')
            ]
        )->get(config('app.api_host') . '/api/v1/store/get_store');

        $storedata  = json_decode($storedata);

        // dd($storedata);

        $itemdata = Http::withHeaders(
            [
                'Authorization' => 'Bearer ' . Session::get('token'),
                'api_key' => config('app.api_key')
            ]
        )->get(config('app.api_host') . '/api/v1/item/get_items', [
            "filter" => [
                "is_active" => 1,
                "orderBy" => 'DESC'
            ]
        ]);

        $itemdata  = json_decode($itemdata);
        $storedata = $storedata->response->store;

        if ($itemdata && $storedata) {
            $message = $itemdata->response->code->message;
            if ($itemdata->response->code->key != 101) {
                return back();
            } else {
                // dd($itemdata);
                $itemdata = $itemdata->response->item;
                return view('welcome', compact('storedata', 'itemdata'));
            }
        } else {
            return back();
        }
    }
}
