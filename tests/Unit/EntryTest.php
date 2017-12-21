<?php
namespace Tests\Feature;

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
}