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
        Schema::create('examens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('academic_Year_id')->constrained();
            $table->date('date');
            $table->string('status');  //Pending Or Done
            /**
             * ! Polymorphic Relation between Examen an CC Model an SN Model 
             */
            $table->integer('examable_id')->nullable();
            $table->string('examable_type')->nullable();

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
        Schema::dropIfExists('examens');
    }
};
