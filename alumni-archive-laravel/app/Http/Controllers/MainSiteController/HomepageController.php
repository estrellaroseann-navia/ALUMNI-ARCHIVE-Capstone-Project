<?php

namespace App\Http\Controllers\MainSiteController;

use App\Models\Milestone;
use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Models\HomepageContent;
use App\Http\Controllers\Controller;

class HomepageController extends Controller
{
    public function index()
    {
        $content = HomepageContent::where('status', 1)->get();
        $milestone = Milestone::where('status', 1)->orderBy('created_at', 'desc')->get();
        $announcement = Announcement::where('status', 1)->orderBy('created_at', 'desc')->get();
        return view('mainsite.pages.home', compact('content', 'milestone', 'announcement'));
    }
}
