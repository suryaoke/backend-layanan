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
        Schema::create('nilaisiswa_kd4s', function (Blueprint $table) {
            $table->id();
            $table->integer('id_rombelsiswa')->nullable();
            $table->integer('id_nilaikd4')->nullable();
            $table->string('nilai')->nullable();
            $table->string('remedial')->nullable();
            $table->string('feedback')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('nilaisiswa_kd4s');
    }
};
