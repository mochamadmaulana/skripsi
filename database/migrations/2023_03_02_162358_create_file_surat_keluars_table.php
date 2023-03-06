<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileSuratKeluarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_surat_keluars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surat_keluar_id');
            $table->string('folder',35);
            $table->string('nama_file', 125);
            $table->string('extention',10);
            $table->string('uri');
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
        Schema::dropIfExists('file_surat_keluars');
    }
}
