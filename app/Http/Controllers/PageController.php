<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        return view('pages.home');
    }

    public function roasEngine(): View
    {
        return view('pages.roas-engine');
    }

    public function services(): View
    {
        return view('pages.services');
    }

    public function caseStudies(): View
    {
        return view('pages.case-studies');
    }

    public function team(): View
    {
        return view('pages.team');
    }

    public function contact(): View
    {
        return view('pages.contact');
    }

    public function smb(): View
    {
        return view('pages.smb');
    }
}
