<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function __invoke()
    {
        $faqs = Faq::all();
        
        return view('pages.faqs', compact('faqs'));
    }
}
