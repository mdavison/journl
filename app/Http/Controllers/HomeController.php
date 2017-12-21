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
        $entries = Journal::entriesForUserID(auth()->id());
        $paginatedEntries = paginate($entries, 20);
        $paginatedEntries->withPath('/home');

        return view('home', ['entries' => $paginatedEntries]);
    }
}
