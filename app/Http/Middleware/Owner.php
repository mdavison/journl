<?php

namespace App\Http\Middleware;

use App\Entry;
use App\Journal;
use Closure;

class Owner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (in_array('journals', $request->segments())) {
            $journalID = $request->segments()[1];
            $journal = Journal::findOrFail($journalID);
        } else if (in_array('entries', $request->segments())) {
            $entryID = $request->segments()[1];
            $entry = Entry::findOrFail($entryID);
            $journal = Journal::findOrFail($entry->journal_id);
        }
        if (!empty($journal) && ($journal->user_id != auth()->id())) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
