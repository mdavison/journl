<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateEntriesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function an_authorized_user_may_create_an_entry()
    {
        // Given we have an authenticated user
        $this->signIn();

        // And an existing journal
        // And the journal user_id is the authenticated user
        $journal = factory('App\Journal')->create([
            'user_id' => auth()->id()
        ]);
        $entry = factory('App\Entry')->make([
            'journal_id' => $journal->id
        ]);

        // When the user adds an entry to the journal
        $this->post($journal->path() . '/entries', $entry->toArray());

        // Then the entry should be included on the page
        $this->get($journal->path())->assertSee($entry->body);
    }

    /** @test */
    public function an_unauthenticated_user_may_not_create_an_entry()
    {
        $this->withoutExceptionHandling();

        $this->expectException('Illuminate\Auth\AuthenticationException');

        factory('App\Journal')->create();

        $this->post('/journals/1/entries', []);
    }
}
