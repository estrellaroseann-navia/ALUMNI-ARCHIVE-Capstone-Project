<?php

namespace App\Http\Controllers\MainSiteController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TakeSurveyController extends Controller
{
    public function index()
    {
        return view('mainsite.pages.survey');
    }
}
