<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class InformationController extends Controller
{
    public function legal(): View
    {
        return view('pages.legal', ['business' => config('business'), 'legal' => config('legal')]);
    }

    public function privacy(): View
    {
        return view('pages.privacy', ['business' => config('business'), 'legal' => config('legal')]);
    }
}
