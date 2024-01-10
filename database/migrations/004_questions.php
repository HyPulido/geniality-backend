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
        Schema::connection(getenv('DB_DATABASE'))->create('questions', function (Blueprint $table) {
            $table->id();      
            $table->string('question', 255);
            $table->boolean('correct_answer');
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
        Schema::connection(getenv('DB_DATABASE'))->dropIfExists('questions');
    }
};