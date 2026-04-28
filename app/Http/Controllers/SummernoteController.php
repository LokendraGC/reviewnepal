<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class SummernoteController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $year = Carbon::now()->year;
            $month = Carbon::now()->month;
            $path = $request->file('file')->store("editor-images/{$year}/{$month}", 'public');
            $url = asset('storage/' . $path);
            return response()->json(['url' => $url]);
        }

        return response()->json(['error' => 'No image uploaded'], 400);
    }
}
