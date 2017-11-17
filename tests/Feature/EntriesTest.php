<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class EntriesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function an_authorized_user_may_create_an_entry()
    {
        $this->signIn();

        $journal = factory('App\Journal')->create([
            'user_id' => auth()->id()
        ]);
        $entry = factory('App\Entry')->make([
            'journal_id' => $journal->id
        ]);

        $this->post($journal->path() . '/entries', $entry->toArray());

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

    /** @test */
    public function an_entry_requires_a_body()
    {
        $this->signIn();

        $journal = factory('App\Journal')->create([
            'user_id' => auth()->id()
        ]);
        $entry = factory('App\Entry')->make([
            'journal_id' => $journal->id,
            'body' => null
        ]);

        $this->post('/journals/1/entries', $entry->toArray())
            ->assertSessionHasErrors('body');

    }
}
