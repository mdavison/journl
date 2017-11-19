<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        $journals = factory('App\Journal', 50)->create();
        $journals->each(function ($journal) {
            factory('App\Entry', 10)->create(['journal_id' => $journal->id]);
        });
    }
}
