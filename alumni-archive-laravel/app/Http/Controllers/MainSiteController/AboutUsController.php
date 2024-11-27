<?php

namespace App\Http\Controllers\MainSiteController;

use Illuminate\Http\Request;
use App\Models\AboutUsContent;
use App\Http\Controllers\Controller;

class AboutUsController extends Controller
{
    public function index()
    {
        $content = AboutUsContent::all();
        return view('mainsite.pages.about', compact('content'));
    }
}
