<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

use function PHPSTORM_META\type;

class ConfirmController extends Controller
{
    public function confirm_view()
    {
        try {
            $data = Http::withHeaders(
                [
                    'Authorization' => 'Bearer ' . Session::get('token'),
                    'api_key' => config('app.api_key')
                ]
            )->get(config('app.api_host') . '/api/v1/booking/get_bookings');

            $data  = json_decode($data);
            // dd($data->response);

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

                if ($value->status_id == 1 || $value->status_id == 4) {
                    unset($data->response->booking[$key]);
                }
            }

            if ($data) {
                $message = $data->response->code->message;
                if ($data->response->code->key != 101) {
                    return back();
                } else {
                    $response = $data->response->booking;
                    // dd($response);
                    return view('booking_confirm.index', compact('response'));
                }
            } else {
                return back();
            }
            // dd($data->response->booking[0]->booking_item);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function confirm_view_item($id)
    {
        try {
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
                $data->response->booking[0]->booking_item[$key]->is_not_return = $item->response->item[0]->is_not_return;
            }

            if ($data) {
                $message = $data->response->code->message;
                if ($data->response->code->key != 101) {
                    return back();
                } else {
                    $response = $data->response->booking[0];
                    // dd($response);
                    return view('booking_confirm.view_item', compact('response'));
                }
            } else {
                return back();
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    function confirm_status(Request $request)
    {
        try {
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

            $message = $data->response->code->message;
            if ($booking_item || $data) {
                if ($booking_item->response->code->key != 101) {
                    return redirect()->route('confirm_view', compact('message'));
                } else {
                    return redirect()->route('confirm_view', compact('message'));
                }
            } else {
                return back();
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    function confirm_reject(Request $request)
    {
        try {
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
            $message = $data->response->code->message;
            if ($booking_item) {
                if ($booking_item->response->code->key != 101) {
                    return redirect()->route('confirm_view', compact('message'));
                } else {
                    return redirect()->route('confirm_view', compact('message'));
                }
            } else {
                return back();
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    function confirm_status_item(Request $request)
    {
        try {
            // dd($request->all());
            $formdata = array();

            for ($i = 1; $i <= count($request->all()); $i++) {
                if ($request['id' . strval($i)] == null) {
                    break;
                } elseif ($request['status_id' . strval($i)] == 5 || $request['status_id' . strval($i)] == 9) {
                    continue;
                } else {
                    $note = (!$request['note_owner' . strval($i)]) ? "ยืม" : $request['note_owner' . strval($i)];


                    if ($request['radio' . strval($i)] == 0) {
                        $formdata[$i]["id"] = $request['id' . strval($i)];
                        $formdata[$i]["note_owner"] = $note;
                        $formdata[$i]["status_id"] = 5;
                    } elseif ($request['radio' . strval($i)] == 2) {
                        continue;
                    } else {
                        $formdata[$i]["id"] = $request['id' . strval($i)];
                        $formdata[$i]["note_owner"] = $note;
                        $formdata[$i]["status_id"] = $request['status_id' . strval($i)] + 1;
                    }
                    // $formdata[$i]["status_id"] = ($request['radio' . strval($i)] == 0) ? 5 : $request['status_id' . strval($i)] + 1;
                }
            }
            // dd($formdata);
            if (!$formdata) {
                return back()->with('message', 'ไม่มีข้อมูล');
            }

            // dd($request->id, $note, $request->status_id + 1);
            $data  = Http::withHeaders(
                [
                    'Authorization' => 'Bearer ' . Session::get('token'),
                    'api_key' => config('app.api_key')
                ]
            )->patch(config('app.api_host') . '/api/v1/booking/update_items_by_staff', [
                "booking_item" => $formdata
            ]);
            $data  = json_decode($data);
            if ($data) {
                if ($data->response->code->key != 101) {
                    $message = $data->response->code->message;
                    dd($data->response);
                    return back()->with('message', $message);
                } else {
                    return back();
                }
            } else {
                return back();
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    function confirm_reject_item(Request $request)
    {
        try {
            $note = ($request->note == null) ? "ไม่ให้ยืม" : $request->note;
            // dd($request->id, $note, $request->status_id - 1);

            $data  = Http::withHeaders(
                [
                    'Authorization' => 'Bearer ' . Session::get('token'),
                    'api_key' => config('app.api_key')
                ]
            )->patch(config('app.api_host') . '/api/v1/booking/update_items_by_staff', [
                "booking_item" => [[
                    "id" => $request->id,
                    "note_owner" => $note,
                    "status_id" => $request->status_id - 1
                ]]
            ]);
            $data  = json_decode($data);
            if ($data) {
                if ($data->response->code->key != 101) {
                    $message = $data->response->code->message;

                    return back()->with('message', $message);
                } else {
                    return back();
                }
            } else {
                return back();
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function history()
    {
        try {
            $data = Http::withHeaders(
                [
                    'Authorization' => 'Bearer ' . Session::get('token'),
                    'api_key' => config('app.api_key')
                ]
            )->get(config('app.api_host') . '/api/v1/booking/get_bookings', [
                "filter" => [
                    "status" => 'complete',
                ]
            ]);

            $data  = json_decode($data);
            // dd($data->response);

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


            if ($data) {
                $message = $data->response->code->message;
                if ($data->response->code->key != 101) {
                    return back();
                } else {
                    $response = $data->response->booking;
                    // dd($response);

                    return view('history.index', compact('response'));
                }
            } else {
                return back();
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
