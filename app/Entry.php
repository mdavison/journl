<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Entry extends Model
{
    protected $guarded = [];

    public function journalName()
    {
        $journal = Journal::findOrFail($this->journal_id);

        return $journal->name;
    }

    public function displayDate()
    {
        // Convert entry_date to Carbon instance
        $ts = strtotime($this->entry_date);
        $year = date('Y', $ts);
        $month = date('m', $ts);
        $day = date('d', $ts);
        $entryDateCarbon = Carbon::createFromDate($year, $month, $day, 'GMT');

        return $entryDateCarbon->diffForHumans();
    }
}
