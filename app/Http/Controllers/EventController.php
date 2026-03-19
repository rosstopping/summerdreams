<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function __invoke()
    {
        $events = Event::where('hidden', false)->orderBy('created_at')->get();
        
        return view('event.index', compact('events'));
    }

    public function show(Event $event) {        
        return view('event.show', compact('event'));
    }
}
