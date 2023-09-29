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
        Schema::table('waktus', function (Blueprint $table) {
            $table->integer('jp')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('created_by')->nullable();
     
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('waktus', function (Blueprint $table) {
            //
        });
    }
};
