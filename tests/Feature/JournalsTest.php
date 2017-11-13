<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class JournalsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_view_all_journals()
    {
        $journal = factory('App\Journal')->create();

        $response = $this->get('/journals');
        $response->assertSee($journal->name);
    }

    /** @test */
    public function a_user_can_view_a_single_journal()
    {
        $journal = factory('App\Journal')->create();

        $response = $this->get('/journals/' . $journal->id);
        $response->assertSee($journal->name);
    }
}
