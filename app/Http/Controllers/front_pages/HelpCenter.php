<?php

namespace App\Http\Controllers\front_pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Document;

class HelpCenter extends Controller
{
  public function index()
  {
    $documents = Document::latest()->take(10)->get(); 
    $pageConfigs = ['myLayout' => 'front'];
    return view('content.front-pages.help-center-landing', compact('documents'), ['pageConfigs' => $pageConfigs]);
  }
}
