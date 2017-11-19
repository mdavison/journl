<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $guarded = [];

    public function path()
    {
        return "/journals/{$this->id}";
    }

    public function entries()
    {
        return $this->hasMany(Entry::class);
    }

    public function addEntry($entry)
    {
        $this->entries()->create($entry);
    }

    public function entriesForUserID($userID)
    {
        return Journal::where('user_id', $userID)
            ->with('entries')
            ->orderBy('created_at', 'desc')
            ->get()
            ->pluck('entries')
            ->first();
    }
}
