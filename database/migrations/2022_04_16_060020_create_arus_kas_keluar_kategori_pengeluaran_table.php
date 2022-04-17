<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArusKasKeluarKategoriPengeluaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arus_kas_keluar_kategori_pengeluaran', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('arus_kas_keluar_id');
            $table->unsignedBigInteger('kategori_pengeluaran_id');
            $table->timestamps();

            $table->foreign('arus_kas_keluar_id','kas_keluar_kategori')->references('id')->on('arus_kas_keluars')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('kategori_pengeluaran_id','kategori_kas_keluar')->references('id')->on('kategori_pengeluarans')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('arus_kas_keluar_kategori_pengeluaran');
    }
}
