# Flashcard Application

## Description

This flashcard application is designed to help users create and study flashcards for various topics. It features the ability to tag flashcards for organized study sessions and implements a system where users can track their progress over time based on their recall difficulty.

## Features

- Create, update, and delete flashcards.
- Organize flashcards by tags.
- Study mode that allows for spaced repetition learning.
- Track recall success over sessions to adjust the frequency of card review.

## Technologies Used

- Laravel: Framework used for server-side logic.
- MySQL: Database for storing user data and flashcards.
- Bootstrap: For styling the front-end components.

## Installation

1. **Clone the repository:**
   ``` bash
   mkdr flashcard
   cd flashcard
   git clone https://github.com/Plukio/FlashCard.git

2. **Install Dependencies:**
   ``` bash
   composer install
   npm install
   npm run dev

3. **Generate an application key:**
   ``` bash
   php artisan key:generate

4. **Run database migrations and seeders (generate syntactic data):**
   ``` bash
   php artisan migrate --seed

5. **Start the application:**
   ``` bash
   php artisan serve

