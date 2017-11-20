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

    /**
     * Returns a collection of entries for a specific user ID
     *
     * @param $userID
     * @return mixed
     */
    public static function entriesForUserID($userID)
    {
        return Journal::where('user_id', $userID)
            ->with('entries')
            ->get()
            ->pluck('entries')
            ->first()
            ->sortByDesc('created_at');
    }

    public static function journalsForUserID($userID)
    {
        return Journal::where('user_id', auth()->id())->orderBy('name', 'asc')->get();
    }
}
