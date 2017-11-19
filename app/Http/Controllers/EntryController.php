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

        if ($journal->id != auth()->id()) {
            return redirect()->back()->withErrors(['user_id' => 'Journal does not belong to the current user']);
        }

        $journal->addEntry([
            'body' => request('body'),
        ]);

        return back()->with('status', 'Your entry has been added successfully.');
    }
}
