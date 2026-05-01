<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('exam_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('exam_id')->constrained()->onDelete('cascade');
            $table->datetime('started_at');
            $table->datetime('completed_at')->nullable();
            $table->json('answers')->nullable();
            $table->json('marked_questions')->nullable();
            $table->integer('score')->nullable();
            $table->integer('percentage')->nullable();
            $table->enum('status', ['in-progress', 'completed', 'expired'])->default('in-progress');
            $table->integer('tab_switch_count')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('exam_attempts');
    }
};
