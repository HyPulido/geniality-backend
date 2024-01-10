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
        Schema::connection(getenv('DB_DATABASE'))->create('answers', function (Blueprint $table) {
            $table->id();
            $table->boolean('answer');
            $table->bigInteger('questions_id')->unsigned();
            $table->bigInteger('users_id')->unsigned();
            $table->timestamps();
            $table->foreign('questions_id')
            ->references('id')
            ->on('questions');
            $table->foreign('users_id')
            ->references('id')
            ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection(getenv('DB_DATABASE'))->dropIfExists('answers');
    }
};