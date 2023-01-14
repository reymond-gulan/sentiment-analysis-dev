<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollegesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('colleges', function (Blueprint $table) {
            $table->id();
            $table->string('college_code', 255);
            $table->string('college_name', 255);
            $table->string('college_dean', 255)->nullable();
            $table->unsignedBigInteger('campus_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->datetime('deleted_at')->nullable();

            $table->foreign('campus_id')->references('id')->on('campuses')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('colleges');
    }
}
