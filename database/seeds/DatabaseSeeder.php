<?php

use App\Models\Author;
use App\Models\City;
use App\Models\Post;
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
        $cities = include_once __DIR__ . '/laravel_ar_query_table_cities.php';
        $authors = include_once __DIR__ . '/laravel_ar_query_table_authors.php';
        $posts = include_once __DIR__ . '/laravel_ar_query_table_posts.php';
        
        foreach ($cities as $city) {
            City::updateOrCreate($city);
        }
        
        foreach ($authors as $author) {
            Author::updateOrCreate($author);
        }
        
        foreach ($posts as $post) {
            Post::updateOrCreate($post);
        }
    }
}
