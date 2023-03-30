<?php

namespace Database\Seeders;

use App\Models\Quiz;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::find(1)->quiz()->create([
            'teacher' => 'HT',
            'course' => '普通物理(一)',
            'type' => '小考',
            'year' => '110',
            'course_year' => '1',

            'tags' => [

            ],
            'filename' => 'quiz_1.pdf',
            'path' => 'quizzes/quiz_1.pdf',
        ]);
    }
}
