<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function __invoke()
    {
        $reviews = Review::all();

        return view('pages.reviews', compact('reviews'));
    }
}
