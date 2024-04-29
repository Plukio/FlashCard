<?php

namespace Database\Factories;

use App\Models\Flashcard;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FlashcardFactory extends Factory
{
    protected $model = Flashcard::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'front' => $this->faker->sentence,
            'back' => $this->faker->sentence,
            'created_at' => now(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Flashcard $flashcard) {
            $tags = Tag::factory()->count(rand(1, 3))->create();
            $flashcard->tags()->attach($tags);
        });
    }
}
