<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use Illuminate\Support\Facades\DB;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('books')->delete();
        Book::create([
            'title' => 'php doc',
            'isbn' => '97800',
            'price' => '13.40',
            'cover' => '',
            'author_id' => 1,
        ]);
        Book::create([
            'title' => 'laravel doc',
            'isbn' => '3242',
            'price' => 12.55,
            'cover' => '',
            'author_id' => 2,
        ]);
    }
}
