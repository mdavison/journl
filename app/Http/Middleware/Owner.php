<?php

namespace App\Http\Middleware;

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
            if ($journal->user_id != auth()->id()) {
                abort(403, 'Unauthorized action.');
            }
        }
        if (in_array('entries', $request->segments())) {
            var_dump('find the user id from the entry');
        }

        return $next($request);
    }
}
