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

        //factory('App\Entry', 50)->create();

        $journals = factory('App\Journal', 50)->create();
        $journals->each(function ($journal) {
            factory('App\Entry', 10)->create(['user_id' => $journal->user_id, 'journal_id' => $journal->id]);
        });
    }
}
