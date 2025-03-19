<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Gigi',
        //     'email' => 'gigi@example.com',
        // ]);

        
        // $this->call(PostSeeder::class);
        // $this->call(CategorySeeder::class);
        $this->call(CommentSeeder::class);
    }
}
