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
        Schema::create('chat_suite_sections', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('outline')->nullable();
            $table->string('model')->nullable();
            $table->string('file_id')->nullable();
            $table->string('job_id')->nullable();
            $table->bigInteger('chat_suite_id')->unsigned()->index();
            $table->foreign('chat_suite_id')->references('id')->on('chat_suite')->onDelete('cascade');
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
        Schema::dropIfExists('chat_suite_sections');
    }
};
