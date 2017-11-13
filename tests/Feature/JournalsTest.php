<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class JournalsTest extends TestCase
{
    use DatabaseMigrations;

    protected $journal;

    protected function setUp()
    {
        parent::setUp();

        $this->journal = factory('App\Journal')->create();
    }

    /** @test */
    public function a_user_can_view_all_journals()
    {
        $response = $this->get('/journals');
        $response->assertSee($this->journal->name);
    }

    /** @test */
    public function a_user_can_view_a_single_journal()
    {
        $response = $this->get('/journals/' . $this->journal->id);
        $response->assertSee($this->journal->name);
    }

    /** @test */
    public function a_user_can_read_journal_entries()
    {
        // Given we have a journal
        // And that journal has entries
        $entry = factory('App\Entry')->create(['journal_id' => $this->journal->id]);
        // When we visit the journal page
        $response = $this->get('/journals/' . $this->journal->id);
        // We should see all the entries
        //var_dump($entry[0]->body);
        $response->assertSee($entry->body);
    }
}
