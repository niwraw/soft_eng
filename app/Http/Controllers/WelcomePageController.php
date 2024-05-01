<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Answers;
use App\Models\Announcement;
use App\Models\StartEnd;
use Carbon\Carbon;

class WelcomePageController extends Controller
{
    public function index($currentRoute)
    {
        $answers = Answers::join('queries', 'queries.id', '=', 'response.query_id')
            ->select('response.*', 'queries.question')
            ->paginate(6);

        $announcements = Announcement::all();
        
        $announcements->each(function ($annoucement) {
            $annoucement->date = Carbon::parse($annoucement->date)->format('F j, Y');
        });

        $start = StartEnd::where('status', 'start')->orderBy('id', 'asc')->first();
        $end = StartEnd::where('status', 'end')->orderBy('id', 'asc')->first();

        $start->date = Carbon::parse($start->date)->format('F j, Y');

        $end->date = Carbon::parse($end->date)->format('F j, Y');

        return view('welcome', compact('currentRoute', 'answers', 'announcements', 'start', 'end'));
    }
}
