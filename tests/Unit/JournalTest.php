<?php

namespace Tests\Unit;

use App\Journal;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class JournalTest extends TestCase
{
    use DatabaseMigrations;

    protected $journal;

    protected function setUp()
    {
        parent::setUp();

        $this->journal = factory('App\Journal')->create();
    }

    /** @test */
    public function it_has_entries()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->journal->entries);
    }

    /** @test */
    public function it_can_add_an_entry()
    {
        $this->journal->addEntry([
            'body' => 'Foobar',
        ]);

        $this->assertCount(1, $this->journal->entries);
    }

    /** @test */
    public function it_can_make_a_string_path()
    {
        $this->assertEquals('/journals/' . $this->journal->id, $this->journal->path());
    }

    /** @test */
    public function it_can_get_all_the_entries_for_a_user()
    {
        $this->signIn();
        $userID = auth()->id();

        $journal = factory('App\Journal')->create([
            'user_id' => $userID
        ]);

        $entriesForLoggedInUser = factory('App\Entry', 3)->create([
            'journal_id' => $journal->id
        ]);

        $entriesForOtherUser = factory('App\Entry', 5)->create([
            'journal_id' => $this->journal->id
        ]);

        $entries = Journal::entriesForUserID($userID);

        // It should contain all the entries for the logged in user
        $this->assertEquals($entriesForLoggedInUser->pluck('body'), $entries->pluck('body'));
        // And should not contain an entry for the other user
        $this->assertNotContains($entriesForOtherUser->pluck('body')[0], $entries->pluck('body'));
    }

    /** @test */
    public function it_can_get_all_the_journals_for_a_user()
    {
        $this->signIn();
        $userID = auth()->id();

        $journalsForSignedInUser = factory('App\Journal', 3)->create([
            'user_id' => $userID
        ]);

        $journalsForAnotherUser = factory('App\Journal', 5)->create();

        $journals = Journal::journalsForUserID($userID);
        $journalsIDs = $journals->pluck('id');

        // Journals created for signed in user should appear in the $journals array
        $journalsForSignedInUserIDs = $journalsForSignedInUser->pluck('id');
        foreach ($journalsForSignedInUserIDs as $id) {
            $this->assertContains($id, $journalsIDs);
        }

        // Journals for the other user should not appear
        $journalsForAnotherUserIDs = $journalsForAnotherUser->pluck('id');
        foreach ($journalsForAnotherUserIDs as $id) {
            $this->assertNotContains($id, $journalsIDs);
        }
    }
}
