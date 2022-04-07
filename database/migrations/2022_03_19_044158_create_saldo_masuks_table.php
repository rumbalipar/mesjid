<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaldoMasuksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saldo_masuks', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->double('jumlah');
            $table->string('deskripsi')->nullable(true)->default(null);
            $table->string('pemberi')->nullable(true)->default(null);
            $table->string('penerima')->nullable(true)->default(null);
            $table->unsignedBigInteger('kategori_pemasukan_id')->nullable(true)->default(null);
            $table->unsignedBigInteger('tipe_pembayaran_id')->nullable(true)->default(null);
            $table->text('keterangan')->nullable(true)->default(null);
            $table->timestamps();

            $table->foreign('kategori_pemasukan_id')->references('id')->on('kategori_pemasukans')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('tipe_pembayaran_id')->references('id')->on('tipe_pembayarans')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('saldo_masuks');
    }
}
