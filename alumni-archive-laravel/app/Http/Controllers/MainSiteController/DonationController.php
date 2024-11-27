<?php

namespace App\Http\Controllers\MainSiteController;

use Illuminate\Http\Request;
use App\Models\DonationContent;
use App\Http\Controllers\Controller;

class DonationController extends Controller
{
    public function index()
    {
        $content = DonationContent::all();
        return view('mainsite.pages.donation', compact('content'));
    }
}
