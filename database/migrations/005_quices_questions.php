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
        Schema::connection(getenv('DB_DATABASE'))->create('quices_questions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('quices_id')->unsigned();
            $table->bigInteger('questions_id')->unsigned();
            $table->foreign('quices_id')
            ->references('id')
            ->on('quices');
            $table->foreign('questions_id')
            ->references('id')
            ->on('questions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection(getenv('DB_DATABASE'))->dropIfExists('quices_questions');
    }
};