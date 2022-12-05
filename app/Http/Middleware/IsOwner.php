<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;

class IsOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $data = Http::withHeaders([
                'Authorization' => 'Bearer ' . Session::get('token'),
                'api_key' => config('app.api_key')
            ])->get(config('app.api_host') . '/api/v1/user/get_current');

            $data  = json_decode($data);

            foreach ($data->response->user->roles as $value) {
                if ($value->name == 'owner') {
                    return $next($request);
                }
            }
            return back()->withInput();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
