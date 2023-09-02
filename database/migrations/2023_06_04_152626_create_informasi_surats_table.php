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
        Schema::create('informasi_surats', function (Blueprint $table) {
            $table->id();
            $table->string('tujuan_surat')->nullable();
            $table->string('perihal')->nullable();
            $table->integer('id_naskah')->nullable();
            $table->string('no_agenda')->nullable();
            $table->string('tgl_surat')->nullable();
            $table->string('no_surat')->nullable();
            $table->string('status')->nullable();
            $table->softDeletes();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('informasi_surats');
    }
};
