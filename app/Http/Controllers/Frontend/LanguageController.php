<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function setLanguage(Request $request)
    {
        $validated = $request->validate([
            'lang' => 'required|string|in:en,ne',
        ]);

        $request->session()->put('lang', $validated['lang']);

        return response()->json([
            'success' => true,
            'lang' => $validated['lang'],
            'redirect_url' => url('/'),
        ]);
    }
}
