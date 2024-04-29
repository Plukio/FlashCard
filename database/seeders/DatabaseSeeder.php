<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Flashcard;
use App\Models\Tag;
use App\Models\Answer;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $user = User::factory()->create([
            'name' => 'Test3User',
            'email' => 'test3@example.com',
        ]);

        $tags = Tag::factory(5)->create(

        );

        $flashcards = Flashcard::factory(10)->create(['user_id' => $user->id])
                        ->each(function ($flashcard) use ($tags) {
                            $flashcard->tags()->attach(
                                $tags->random(rand(1, 3))->pluck('id')->toArray()
                            );
                        });

        $flashcards->each(function ($flashcard) use ($user) {
            Answer::factory(rand(1, 3))->create([
                'flashcard_id' => $flashcard->id,
                'user_id' => $user->id
            ]);
        });
    }
}
