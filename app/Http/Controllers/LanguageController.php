<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function switch(Request $request, string $locale)
    {
        if (!in_array($locale, ['en', 'si'])) {
            $locale = 'en';
        }

        session(['locale' => $locale]);

        if ($request->user()) {
            $request->user()->update(['preferred_language' => $locale]);
        }

        return back();
    }
}
