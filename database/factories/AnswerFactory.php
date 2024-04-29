<?php

namespace Database\Factories;


use App\Models\Answer;
use App\Models\Flashcard;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnswerFactory extends Factory
{
    protected $model = Answer::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'flashcard_id' => Flashcard::factory(),
            'difficulty_level' => $this->faker->randomElement(['easy', 'medium', 'hard']),
            'answered_at' => now(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Answer $answer) {
           
            
            if (is_null($answer->flashcard_id)) {
                $flashcard = Flashcard::factory()->create();
                $answer->flashcard_id = $flashcard->id;
            }
            if (is_null($answer->user_id)) {
                $user = User::factory()->create();
                $answer->user_id = $user->id;
            }    
        });
    }
    
}

