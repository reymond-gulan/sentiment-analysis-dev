<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_answers', function (Blueprint $table) {
            $table->id();
            $table->integer('answer');
            $table->unsignedBigInteger('question_id');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('campus_id');
            $table->unsignedBigInteger('office_id')->nullable();
            $table->unsignedBigInteger('college_id')->nullable();

            $table->foreign('question_id')->references('id')->on('questions')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('college_id')->references('id')->on('colleges')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('office_id')->references('id')->on('offices')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('campus_id')->references('id')->on('campuses')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('survey_answers');
    }
}
