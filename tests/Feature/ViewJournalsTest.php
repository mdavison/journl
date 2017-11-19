<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ViewJournalsTest extends TestCase
{
    use DatabaseMigrations;

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

        // Create journal for diff user
        $journal = factory('App\Journal')->create();

        $this->get($journal->path())
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
    public function a_user_cannot_access_another_users_journal()
    {
        $this->signIn();

        // Create journal for diff user
        $journal = factory('App\Journal')->create();

        $this->get($journal->path())
            ->assertStatus(403);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_view_journals()
    {
        $journal = factory('App\Journal')->create();

        $this->get($journal->path())
            ->assertRedirect('/login');
    }

    /** @test */
    public function a_user_can_only_view_their_own_journals()
    {
        $this->signIn();

        $firstJournal = factory('App\Journal')->create([
            'user_id' => auth()->id(),
            'name' => 'first'
        ]);

        $anotherJournal = factory('App\Journal')->create([
            'name' => 'second'
        ]);

        $this->get('/journals')
            ->assertSee($firstJournal->name)
            ->assertDontSee($anotherJournal->name);
    }
}
