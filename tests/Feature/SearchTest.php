<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_search_journals_by_name()
    {
        $this->signIn();

        $search = 'foobar';

        factory('App\Journal', 2)->create([
            'user_id' => auth()->id()
        ]);
        factory('App\Journal', 2)->create([
            'user_id' => auth()->id(),
            'name' => "A journal with the {$search} term."
        ]);

        $results = $this->getJson("/search?q={$search}")->json()['data'];

        $this->assertCount(2, $results);
    }

    /** @test */
    public function a_search_is_case_insensitive()
    {
        $this->signIn();

        $search = 'foobar';

        factory('App\Journal', 2)->create([
            'user_id' => auth()->id()
        ]);
        factory('App\Journal')->create([
            'user_id' => auth()->id(),
            'name' => "A journal with the Foobar term."
        ]);
        factory('App\Journal')->create([
            'user_id' => auth()->id(),
            'name' => "A journal with the foobar term."
        ]);

        $results = $this->getJson("/search?q={$search}")->json()['data'];

        $this->assertCount(2, $results);
    }

    /** @test */
    public function a_user_can_search_journals_by_description()
    {
        $this->signIn();

        $search = 'foobar';

        factory('App\Journal', 2)->create([
            'user_id' => auth()->id()
        ]);
        factory('App\Journal', 2)->create([
            'user_id' => auth()->id(),
            'description' => "A journal description with the {$search} term."
        ]);

        $results = $this->getJson("/search?q={$search}")->json()['data'];

        $this->assertCount(2, $results);
    }

    /** @test */
    public function a_user_can_search_entries_by_body()
    {
        $this->signIn();

        $search = 'foobar';

        $journal = factory('App\Journal')->create([
            'user_id' => auth()->id(),
        ]);
        factory('App\Entry')->create([
            'journal_id' => $journal->id,
            'body' => "Entry with the {$search} term"
        ]);

        $results = $this->getJson("/search?q={$search}")->json()['data'];

        $this->assertCount(1, $results);
    }

    /** @test */
    public function a_search_returns_results_for_both_journals_and_entries()
    {
        $this->signIn();

        $search = 'foobar';

        factory('App\Journal')->create([
            'user_id' => auth()->id(),
            'description' => "Description with the {$search} term."
        ]);

        $journal = factory('App\Journal')->create([
            'user_id' => auth()->id(),
        ]);
        factory('App\Entry')->create([
            'journal_id' => $journal->id,
            'body' => "Entry with the {$search} term"
        ]);
        factory('App\Entry')->create([
            'journal_id' => $journal->id,
        ]);

        $results = $this->getJson("/search?q={$search}")->json()['data'];

        $this->assertCount(2, $results);
    }

    /** @test */
    public function users_must_be_logged_in_to_search()
    {
        $search = 'foobar';

        factory('App\Journal', 2)->create([
            'name' => "A journal with the {$search} term."
        ]);

        $this->get("/search?q={$search}")
            ->assertRedirect('/login');
    }

    /** @test */
    public function a_user_can_only_return_search_results_they_are_authorized_to_view()
    {
        $this->signIn();

        $search = 'foobar';

        factory('App\Journal', 1)->create([
            'user_id' => auth()->id(),
            'name' => "A journal with the {$search} term."
        ]);
        factory('App\Journal', 2)->create([
            'name' => "A journal with the {$search} term."
        ]);

        $results = $this->getJson("/search?q={$search}")->json()['data'];

        $this->assertCount(1, $results);
    }
}
