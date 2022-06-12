<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;

class ForumController extends Controller
{
    //
    public function index()
    {
        $questions = Question::with('user')->with('answers')->orderBy('created_at', 'desc')->get();
        // return response()->json($questions);
        return view('pages.forum', compact('questions'));
    }
}
