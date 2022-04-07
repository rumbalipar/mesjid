<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengajuansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengajuans', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->double('jumlah');
            $table->string('deskripsi')->nullable(true)->default(null);
            $table->unsignedBigInteger('tipe_pembayaran_id')->nullable(true)->default(null);
            $table->unsignedBigInteger('kategori_pengeluaran_id')->nullable(true)->default(null);
            $table->unsignedBigInteger('kategori_pemasukan_id')->nullable(true)->default(null);
            $table->text('keterangan')->nullable(true)->default(null);
            $table->timestamps();

            $table->foreign('tipe_pembayaran_id')->references('id')->on('tipe_pembayarans')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('kategori_pengeluaran_id')->references('id')->on('kategori_pengeluarans')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('kategori_pemasukan_id')->references('id')->on('kategori_pemasukans')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengajuans');
    }
}
