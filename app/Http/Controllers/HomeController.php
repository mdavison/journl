<?php

namespace App\Http\Controllers;

use App\Entry;
use App\Journal;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $journals = Journal::where('user_id', auth()->id())->orderBy('name', 'asc')->get();
        $entries = (new Journal)->entriesForUserID(auth()->id());

        return view('home', compact(['journals', 'entries']));
    }
}
