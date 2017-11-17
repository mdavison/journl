<?php

namespace App\Http\Controllers;

use App\Journal;
use Illuminate\Http\Request;

class EntryController extends Controller
{

    /**
     * EntryController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Journal $journal)
    {
        $this->validate(request(), [
            'body' => 'required'
        ]);

        $journal->addEntry([
            'body' => request('body'),
            'user_id' => auth()->id()
        ]);

        return back();
    }
}
