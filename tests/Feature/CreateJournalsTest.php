<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateJournalsTest extends TestCase
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

        $this->get($journal->path())->assertSee($journal->name);
    }

    /** @test */
    public function a_journal_requires_a_name()
    {
        $this->signIn();

        $journal = factory('App\Journal')->make(['name' => null]);

        $this->post('/journals', $journal->toArray())
            ->assertSessionHasErrors('name');
    }
}