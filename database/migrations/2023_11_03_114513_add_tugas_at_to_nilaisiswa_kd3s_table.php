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
        Schema::table('nilaisiswa_kd3s', function (Blueprint $table) {
            $table->string('tugas')->nullable();
            $table->string('tugas_upload')->nullable();
            $table->string('ket')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nilaisiswa_kd3s', function (Blueprint $table) {
            //
        });
    }
};
