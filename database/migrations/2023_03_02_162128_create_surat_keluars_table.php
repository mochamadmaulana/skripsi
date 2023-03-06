<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuratKeluarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surat_keluars', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_agenda', 6);
            $table->string('nomor_surat');
            $table->string('nama_surat');
            $table->string('ditujukan_kepada');
            $table->date('tanggal_surat');
            $table->date('tanggal_keluar');
            $table->string('perihal',225)->nullable();
            $table->enum('status_approve', ['Prosess','Disetujui','Ditolak']);
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
        Schema::dropIfExists('surat_keluars');
    }
}
