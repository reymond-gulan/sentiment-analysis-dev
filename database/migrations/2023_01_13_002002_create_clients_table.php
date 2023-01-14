<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('id_number')->nullable();
            $table->string('name')->nullable();
            $table->string('yr')->nullable();
            $table->enum('gender',['MALE', 'FEMALE', NULL])->default(NULL)->nullable();

            $table->string('email_address')->nullable();
            $table->string('verification_code');
            $table->boolean('is_verified')->default(false);

            $table->unsignedBigInteger('course_id')->nullable();
            $table->unsignedBigInteger('college_id')->nullable();
            $table->unsignedBigInteger('office_id')->nullable();
            $table->unsignedBigInteger('campus_id')->nullable();
            $table->timestamps();
            $table->datetime('deleted_at')->nullable();

            $table->foreign('course_id')->references('id')->on('courses')->onDelete('restrict')->onUpdate('cascade');
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
        Schema::dropIfExists('clients');
    }
}
