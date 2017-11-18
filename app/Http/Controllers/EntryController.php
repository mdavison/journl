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
            'journal_id' => 'required',
            'body' => 'required'
        ]);

        $journal = Journal::findOrFail(request('journal_id'));

        $journal->addEntry([
            'body' => request('body'),
            'user_id' => auth()->id()
        ]);

        return back()->with('status', 'Your entry has been added successfully.');
    }
}
