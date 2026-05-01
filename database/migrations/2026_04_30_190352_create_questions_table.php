<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->constrained()->onDelete('cascade');
            $table->text('question_text');
            $table->enum('difficulty', ['easy', 'medium', 'hard'])->default('medium');
            $table->integer('marks')->default(1);
            $table->integer('negative_marks')->default(0);
            $table->text('explanation')->nullable();
            $table->enum('type', ['single', 'multiple'])->default('single');
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('questions');
    }
};
