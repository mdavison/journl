<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    protected $guarded = [];

    public function journalName()
    {
        $journal = Journal::findOrFail($this->journal_id);

        return $journal->name;
    }
}
