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
        Schema::create('catata_walas', function (Blueprint $table) {
            $table->id();
            $table->string('id_rombel')->nullable();
            $table->string('id_tahunajar')->nullable();
            $table->string('alfa')->nullable();
            $table->string('sakit')->nullable();
            $table->string('izin')->nullable();
            $table->string('prestasi')->nullable();
            $table->string('ekstra')->nullable();
            $table->string('nilai_ekstra')->nullable();
            $table->string('catatan')->nullable();
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
        Schema::dropIfExists('catata_walas');
    }
};
