<?php

namespace App\Http\Middleware;

use App\Models\attendance_list;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Qr_Checker
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

        $value = $request->get('qr_value');

        $select = attendance_list::where('qr_value' , $value)->where('status', 'available')->first();

        if (!$select){
            return response([
                'message' => 'Invalid QR Code'
            ]);
        }

        Auth::guard('qr')->login($select);

        return $next($request);
    }
}
