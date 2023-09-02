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
        Schema::create('surat_masuk_disposisis', function (Blueprint $table) {
            $table->id();
            $table->integer('id_sm');
            $table->integer('id_pengirim')->nullable();
            $table->string('isi')->nullable();
            $table->integer('id_penerima');
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
        Schema::dropIfExists('surat_masuk_disposisis');
    }
};
