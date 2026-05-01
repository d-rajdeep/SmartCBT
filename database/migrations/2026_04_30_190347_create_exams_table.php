<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->foreignId('category_id')->constrained();
            $table->integer('duration'); // in minutes
            $table->integer('total_questions');
            $table->integer('passing_percentage')->default(40);
            $table->integer('max_attempts')->default(3);
            $table->boolean('is_published')->default(false);
            $table->datetime('start_date')->nullable();
            $table->datetime('end_date')->nullable();
            $table->boolean('randomize_questions')->default(false);
            $table->boolean('show_result_immediately')->default(true);
            $table->json('settings')->nullable(); // Additional settings
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('exams');
    }
};
