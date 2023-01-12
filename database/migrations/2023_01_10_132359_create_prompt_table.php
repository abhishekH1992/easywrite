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
        Schema::create('prompt', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->text('settings');
            $table->string('placeholder')->nullable();
            $table->string('prefix')->nullable();
            $table->string('aiprefix')->nullable();
            $table->string('divider')->nullable();
            $table->string('img')->nullable();
            $table->text('pretext')->nullable();
            $table->string('style')->nullable();
            $table->tinyInteger('isTextarea')->nullable();
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
        Schema::dropIfExists('prompt');
    }
};
