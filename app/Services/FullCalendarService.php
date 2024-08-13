<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Event;

class FullCalendarService
{
    public function events(Request $request)
    {
        $data = Event::whereDate('start', '>=', $request->start)
            ->whereDate('end', '<=', $request->end)
            ->get(['id', 'title', 'start', 'end']);
        return response()->json($data);
    }

    public function add(Request $request){
        $event = Event::create([
            'title' => $request->title,
            'start' => $request->start,
            'end' => $request->end,
        ]);
        return response()->json($event);
    }

    public function update(Request $request){
        $event = Event::find($request->id)->update([
            'title' => $request->title,
            'start' => $request->start,
            'end' => $request->end,
        ]);        
        return response()->json($event);
    }

    public function destroy($id){
        $event = Event::find($id)->delete();  
        return response()->json($event);
    }
    
}