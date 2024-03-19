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
        Schema::create('nilais', function (Blueprint $table) {
            $table->id();
            $table->string('kode_nilai')->nullable();
            $table->string('id_seksi')->nullable();
            $table->string('id_rombelsiswa')->nullable();
            $table->string('id_tahunajar')->nullable();
            $table->string('nilai_pengetahuan')->nullable();
            $table->string('nilai_pengetahuan_akhir')->nullable();
            $table->string('nilai_keterampilan')->nullable();
            $table->string('catatan_pengetahuan')->nullable();
            $table->string('catatan_keterampilan')->nullable();
            $table->string('type_nilai')->nullable();
            $table->string('type_keterampilan')->nullable();
            $table->string('ph')->nullable();
            $table->string('kd')->nullable();
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
        Schema::dropIfExists('nilais');
    }
};
