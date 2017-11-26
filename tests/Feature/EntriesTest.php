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

        $this->post('/entries', $entry->toArray());

        $this->get($journal->path())->assertSee($entry->body);
    }

    /** @test */
    public function an_unauthenticated_user_may_not_create_an_entry()
    {
        $this->withoutExceptionHandling();

        $this->expectException('Illuminate\Auth\AuthenticationException');

        factory('App\Journal')->create();

        $this->post('/entries', []);
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

        $this->post('/entries', $entry->toArray())
            ->assertSessionHasErrors('body');

    }

    /** @test */
    public function an_authenticated_user_should_see_all_their_entries_on_the_home_page()
    {
        $this->signIn();

        $journal = factory('App\Journal')->create([
            'user_id' => auth()->id()
        ]);
        $entry1 = factory('App\Entry')->create([
            'journal_id' => $journal->id,
        ]);
        $entry2 = factory('App\Entry')->create([
            'journal_id' => $journal->id,
        ]);

        $this->get('/home')
            ->assertSee($entry1->body)
            ->assertSee($entry2->body);
    }

    /** @test */
    public function an_authorized_user_cannot_create_an_entry_in_another_users_journal()
    {
        $this->signIn();
        $signedInUser = auth()->id();

        factory('App\Journal')->create([
            'user_id' => $signedInUser
        ]);

        $journalForAnotherUser = factory('App\Journal')->create();

        $entry = factory('App\Entry')->make([
            'journal_id' => $journalForAnotherUser,
        ]);

        $this->post('/entries', $entry->toArray())
            ->assertSessionHasErrors('user_id');

    }

    /** @test */
    public function unauthorized_users_may_not_delete_entries()
    {
        $entry = factory('App\Entry')->create();

        $this->assertDatabaseHas('entries', ['id' => $entry->id]);

        $this->delete('/entries/' . $entry->id)
            ->assertRedirect('/login');

        $this->signIn();

        $response = $this->json('DELETE', '/entries/' . $entry->id);

        $response->assertStatus(403);

        $this->assertDatabaseHas('entries', ['id' => $entry->id]);
    }

    /** @test */
    public function authorized_users_may_delete_entries()
    {
        $this->signIn();

        $journal = factory('App\Journal')->create([
            'user_id' => auth()->id()
        ]);

        $entry = factory('App\Entry')->create([
            'journal_id' => $journal->id
        ]);

        $this->assertDatabaseHas('entries', ['id' => $entry->id]);

        $response = $this->json('DELETE', "/entries/{$entry->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('entries', ['id' => $entry->id]);
    }

    /** @test */
    public function authorized_users_can_update_entries()
    {
        $this->signIn();

        $journal = factory('App\Journal')->create([
            'user_id' => auth()->id()
        ]);
        $entry = factory('App\Entry')->create([
            'journal_id' => $journal->id
        ]);

        $updatedEntry = 'The entry has been changed.';
        $this->patch("/entries/{$entry->id}", ['body' => $updatedEntry]);

        $this->assertDatabaseHas('entries', ['id' => $entry->id, 'body' => $updatedEntry]);
    }

    /** @test */
    public function unauthorized_users_may_not_update_entries()
    {
        $entry = factory('App\Entry')->create();

        $updatedEntry = 'The entry has been changed.';
        $this->patch("/entries/{$entry->id}", ['body' => $updatedEntry])
            ->assertRedirect('/login');

        $this->signIn();

        $this->patch("/entries/{$entry->id}", ['body' => $updatedEntry])
            ->assertStatus(403);

        $this->assertDatabaseMissing('entries', ['id' => $entry->id, 'body' => $updatedEntry]);
    }
}
