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
        Schema::table('prompt', function (Blueprint $table) {
            $table->tinyInteger('isSystem')->nullable();
            $table->longText('system')->nullable();
            $table->tinyInteger('isMenu')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prompt', function (Blueprint $table) {
            $table->dropColumn('isSystem');
            $table->dropColumn('system');
            $table->dropColumn('isMenu');
        });
    }
};
