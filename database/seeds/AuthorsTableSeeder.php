<?php

use Illuminate\Database\Seeder;
use App\Author;

class AuthorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('authors')->delete();

        Author::create([
            'name' => 'author1',
        ]);
        Author::create([
            'name' => 'author2',
        ]);
    }
}
