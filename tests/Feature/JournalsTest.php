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
    public function a_user_can_view_a_single_journal_that_they_created()
    {
        $this->signIn();

        $journal = factory('App\Journal')->create([
            'user_id' => auth()->id()
        ]);

        $this->get($journal->path())
            ->assertSee($journal->name);
    }

    /** @test */
    public function a_user_cannot_view_a_single_journal_that_they_did_not_create()
    {
        $this->signIn();

        $this->get($this->journal->path())
            ->assertStatus(403);
    }

    /** @test */
    public function a_user_can_read_journal_entries_that_they_created()
    {
        $this->signIn();

        $journal = factory('App\Journal')->create([
            'user_id' => auth()->id()
        ]);
        $entry = factory('App\Entry')->create([
            'journal_id' => $journal->id
        ]);

        $this->get($journal->path())
            ->assertSee($entry->body);
    }

    /** @test */
    public function a_user_cannot_read_journal_entries_that_they_did_not_create()
    {
        $this->signIn();

        $entry = factory('App\Entry')->create(['journal_id' => $this->journal->id]);

        $this->get($this->journal->path())
            ->assertStatus(403);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_view_journals()
    {
        $this->get($this->journal->path())
            ->assertRedirect('/login');
    }

    /** @test */
    public function a_user_can_only_view_their_own_journals()
    {
        $this->signIn();

        $firstJournal = factory('App\Journal')->create([
            'user_id' => auth()->id()
        ]);

        $anotherUser = factory('App\User')->create();

        $anotherJournal = factory('App\Journal')->create([
            'user_id' => $anotherUser->id
        ]);

        $this->get('/journals')
            ->assertSee($firstJournal->name)
            ->assertDontSee($anotherJournal->name);
    }
}
