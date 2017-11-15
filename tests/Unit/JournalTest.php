<?php

namespace Tests\Unit;

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
            'user_id' => 1
        ]);

        $this->assertCount(1, $this->journal->entries);
    }
}
