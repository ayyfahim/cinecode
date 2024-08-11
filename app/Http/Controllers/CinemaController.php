<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderCinema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CinemaController extends Controller
{
    public function home(Request $request)
    {
        $url = route('cinema.email.index') . "?c={$request->c}";
        return redirect()->to($url);
    }
    public function movieDownload(Request $request)
    {
        // if (!auth('cinema')->check()) {
        //     return abort(404);
        // }

        if (!$request->has('token') || !$request->has('order')) {
            return abort(404);
        }

        $exist = OrderCinema::where([
            'download_token' => $request->token,
            'order_id' => $request->order,
            'cinema_id' => \CinemaUniqueAuth::user()->id,
        ])->first();

        if (!$exist) {
            return abort(404);
        }

        Order::find($request->order)->update([
            'downloaded' => 1
        ]);

        // $file = Storage::disk('public')->get($exist->order->version->mcck_file);
        // $file_url = Storage::disk('public')->path($exist->order->version->mcck_file);

        if (!$exist->downloaded_movies) {
            $exist->downloaded_movies = true;
            $exist->save();
        };

        // dd($exist, !$exist->downloaded_movies);

        // return response()->download($file_url);
        return response()->redirectTo($exist->order->version->video_link);
    }


    public function playerDownload(Request $request)
    {
        if (!auth('cinema')->check()) {
            return abort(404);
        }
        auth('cinema')->user()->update([
            'downloaded_player' => now()
        ]);
        return response()->redirectTo('https://cinema.cinecode.de/player-lite/download.php?download_code=b8235de2a7f82c85f34927162ce19a03');
    }
}
