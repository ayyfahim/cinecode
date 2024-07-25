<?php

namespace App\Http\Controllers;

use App\Models\OrderCinema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CinemaController extends Controller
{
    public function movieDownload(Request $request)
    {
        if (!$request->has('token') || !$request->has('order')) {
            return abort(404);
        }

        $exist = OrderCinema::where([
            'download_token' => $request->token,
            'order_id' => $request->order,
            // 'cinema_id' => auth('customer')->user()->distributor_id,
        ])->first();

        if (!$exist) {
            return abort(404);
        }

        // $file = Storage::disk('public')->get($exist->order->version->mcck_file);
        $file_url = Storage::disk('public')->path($exist->order->version->mcck_file);

        if (!$exist->downloaded_movies) {
            $exist->downloaded_movies = true;
            $exist->save();
        };

        // dd($exist, !$exist->downloaded_movies);

        return response()->download($file_url);
    }
}
