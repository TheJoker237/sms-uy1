<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->double('cc')->nullable();
            $table->double('tp')->nullable();
            $table->double('ex')->nullable();
            $table->double('total')->nullable();
            $table->double('totalShort')->nullable();
            $table->string('mention')->nullable();
            $table->string('mentionShort')->nullable();
            $table->string('dec')->nullable();
            $table->foreignId('examen_id')->constrained();
            $table->foreignId('student_id')->constrained();
            $table->foreignId('course_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notes');
    }
};
