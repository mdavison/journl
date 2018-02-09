<?php
namespace Tests\Feature;

use App\Entry;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class EntryTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_can_get_the_journal_name()
    {
        $journal = factory('App\Journal')->create();
        $entry = factory('App\Entry')->create([
            'journal_id' => $journal->id
        ]);

        $this->assertEquals($journal->name, $entry->journalName());
    }

    /** @test */
    public function it_can_get_the_display_date()
    {
        // Create a date for yesterday
        $yesterday = strtotime('yesterday');

        $journal = factory('App\Journal')->create();
        $entry = factory('App\Entry')->create([
            'journal_id' => $journal->id,
            'entry_date' => date('Y-m-d', $yesterday)
        ]);

        $this->assertEquals('1 day ago', $entry->displayDate());
    }

    /** @test
     * Database should insert default date of today
     */
    public function it_has_a_default_entry_date()
    {
        $journal = factory('App\Journal')->create();
        $entry = factory('App\Entry')->create([
            'journal_id' => $journal->id
        ]);

        $entry = Entry::find($entry->id);

        $today = date('Y-m-d', strtotime('today'));
        $this->assertEquals($today, $entry->entry_date);
    }
}