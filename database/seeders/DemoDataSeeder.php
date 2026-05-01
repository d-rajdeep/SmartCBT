<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Exam;
use App\Models\Question;
use App\Models\Option;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DemoDataSeeder extends Seeder
{
    public function run()
    {
        // Create categories with slugs
        $categories = [
            [
                'name' => 'General Knowledge',
                'slug' => 'general-knowledge',
                'description' => 'Test your general knowledge'
            ],
            [
                'name' => 'Programming',
                'slug' => 'programming',
                'description' => 'Programming languages and concepts'
            ],
            [
                'name' => 'Mathematics',
                'slug' => 'mathematics',
                'description' => 'Mathematical problems'
            ],
            [
                'name' => 'English',
                'slug' => 'english',
                'description' => 'English language skills'
            ],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // Create a demo exam
        $exam = Exam::create([
            'title' => 'Sample Programming Quiz',
            'slug' => 'sample-programming-quiz',
            'description' => 'A sample quiz to test your programming knowledge',
            'category_id' => 2,
            'duration' => 30,
            'total_questions' => 5,
            'passing_percentage' => 60,
            'max_attempts' => 3,
            'is_published' => true,
            'randomize_questions' => true,
            'show_result_immediately' => true,
            'start_date' => null,
            'end_date' => null,
        ]);

        // Sample questions
        $questions = [
            [
                'text' => 'What does PHP stand for?',
                'options' => [
                    'Personal Home Page',
                    'Preprocessor Hypertext',
                    'PHP: Hypertext Preprocessor',
                    'Public Hosting Protocol'
                ],
                'correct' => 2,
                'explanation' => 'PHP originally stood for Personal Home Page, but now stands for PHP: Hypertext Preprocessor'
            ],
            [
                'text' => 'Which of the following is a valid way to create a variable in JavaScript?',
                'options' => [
                    'var myVar;',
                    'let myVar;',
                    'const myVar;',
                    'All of the above'
                ],
                'correct' => 3,
                'explanation' => 'In JavaScript, you can use var, let, or const to declare variables.'
            ],
            [
                'text' => 'What is Laravel?',
                'options' => [
                    'A JavaScript framework',
                    'A PHP framework',
                    'A Python framework',
                    'A CSS framework'
                ],
                'correct' => 1,
                'explanation' => 'Laravel is a free, open-source PHP web framework.'
            ],
            [
                'text' => 'Which SQL statement is used to extract data from a database?',
                'options' => [
                    'SELECT',
                    'EXTRACT',
                    'GET',
                    'OPEN'
                ],
                'correct' => 0,
                'explanation' => 'The SELECT statement is used to select data from a database.'
            ],
            [
                'text' => 'What does CSS stand for?',
                'options' => [
                    'Creative Style Sheets',
                    'Computer Style Sheets',
                    'Cascading Style Sheets',
                    'Colorful Style Sheets'
                ],
                'correct' => 2,
                'explanation' => 'CSS stands for Cascading Style Sheets.'
            ],
        ];

        foreach ($questions as $index => $qData) {
            $question = Question::create([
                'exam_id' => $exam->id,
                'question_text' => $qData['text'],
                'difficulty' => 'easy',
                'marks' => 1,
                'negative_marks' => 0,
                'explanation' => $qData['explanation'],
                'type' => 'single',
                'order' => $index + 1,
            ]);

            foreach ($qData['options'] as $optIndex => $optionText) {
                Option::create([
                    'question_id' => $question->id,
                    'option_text' => $optionText,
                    'is_correct' => $optIndex == $qData['correct'],
                    'order' => $optIndex + 1,
                ]);
            }
        }

        $this->command->info('Demo data seeded successfully!');
        $this->command->info('Exam created: ' . $exam->title);
        $this->command->info('Total questions: ' . $exam->questions()->count());
    }
}
