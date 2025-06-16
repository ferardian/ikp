<?php

namespace App\Http\Controllers;

use App\Settings\GeneralSettings;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public $settings;

    public function __construct(GeneralSettings $settings) {
        $this->settings = $settings;
    }

    public function  index()
    {
        return view('welcome', [
            'settings' => $this->settings,
        ]);
    }
}
