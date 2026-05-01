<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_attempt_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained();
            $table->foreignId('exam_id')->constrained();
            $table->integer('total_questions');
            $table->integer('correct_answers');
            $table->integer('wrong_answers');
            $table->integer('skipped_answers');
            $table->integer('total_marks_obtained');
            $table->integer('total_marks');
            $table->float('percentage');
            $table->boolean('is_passed');
            $table->json('section_wise_performance')->nullable();
            $table->json('time_spent_per_question')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('results');
    }
};
