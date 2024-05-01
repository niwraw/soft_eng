<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Answers;
use App\Models\Queries;

class WelcomePageController extends Controller
{
    public function index($currentRoute)
    {
        $questions = Queries::all();
        $answers = Answers::join('queries', 'queries.id', '=', 'response.query_id')
            ->select('response.*', 'queries.question')
            ->paginate(6);

        return view('welcome', compact('currentRoute', 'answers'));
    }
}
