<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Whether;

class WheatherController extends Controller
{
    /**
     * Show wheather.
     *
     * @return View
     */
    public function __invoke()
    {
        return view('wheather', [
            'page_title' => 'Погода в Брянске',
            'data' => Whether::get()
        ]);
    }
}
