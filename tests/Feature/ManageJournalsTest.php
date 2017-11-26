<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ManageJournalsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function guests_may_not_create_journals()
    {
        $journal = factory('App\Journal')->make();

        $this->post('/journals', $journal->toArray())
            ->assertRedirect('login');
    }

    /** @test */
    public function an_authenticated_user_can_create_new_journals()
    {
        $this->signIn();

        $journal = factory('App\Journal')->make([
            'user_id' => auth()->id()
        ]);

        $this->post('/journals', $journal->toArray());

        $this->assertDatabaseHas('journals', ['name' => $journal->name]);
    }

    /** @test */
    public function a_journal_requires_a_name()
    {
        $this->signIn();

        $journal = factory('App\Journal')->make(['name' => null]);

        $this->post('/journals', $journal->toArray())
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function unauthorized_users_may_not_delete_journals()
    {
        $journal = factory('App\Journal')->create();

        $this->delete($journal->path())
            ->assertRedirect('/login');

        $this->signIn();

        $response = $this->json('DELETE', $journal->path());

        $response->assertStatus(403);

        $this->assertDatabaseHas('journals', ['id' => $journal->id]);
    }

    /** @test */
    public function authorized_users_may_delete_journals()
    {
        $this->signIn();

        $journal = factory('App\Journal')->create([
            'user_id' => auth()->id()
        ]);

        $response = $this->json('DELETE', $journal->path());

        $response->assertStatus(204);

        $this->assertDatabaseMissing('journals', ['id' => $journal->id]);
    }
}