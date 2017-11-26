<?php

namespace App\Http\Controllers;

use App\Entry;
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
        $this->middleware('owner')->only('destroy', 'update');
    }

    public function store(Journal $journal)
    {
        $this->validate(request(), [
            'journal_id' => 'required',
            'body' => 'required'
        ]);

        $journal = Journal::findOrFail(request('journal_id'));

        if ($journal->user_id != auth()->id()) {
            return redirect()->back()->withErrors(['user_id' => 'Journal does not belong to the current user']);
        }

        $journal->addEntry([
            'body' => request('body'),
        ]);

        return back()->with('flash', 'Your entry has been added.');
    }

    public function update(Entry $entry)
    {
        $this->validate(request(), [
            'body' => 'required'
        ]);

        $entry->update(request(['body']));
    }

    public function destroy(Entry $entry)
    {
        $journal = Journal::find($entry->journal_id);

        $entry->delete();

        if (request()->wantsJson()) {
            return response([], 204);
        }

        return redirect($journal->path())->with('flash', 'Entry was deleted');
    }
}
