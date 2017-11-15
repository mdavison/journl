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
        $this->get('/journals')
            ->assertSee($this->journal->name);
    }

    /** @test */
    public function a_user_can_view_a_single_journal()
    {
        $this->get($this->journal->path())
            ->assertSee($this->journal->name);
    }

    /** @test */
    public function a_user_can_read_journal_entries()
    {
        $entry = factory('App\Entry')->create(['journal_id' => $this->journal->id]);

        $this->get($this->journal->path())
            ->assertSee($entry->body);
    }
}
