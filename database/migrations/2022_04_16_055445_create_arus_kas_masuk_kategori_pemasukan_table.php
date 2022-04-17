<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArusKasMasukKategoriPemasukanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arus_kas_masuk_kategori_pemasukan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('arus_kas_masuk_id');
            $table->unsignedBigInteger('kategori_pemasukan_id');
            $table->timestamps();

            $table->foreign('arus_kas_masuk_id','kas_masuk_kategori')->references('id')->on('arus_kas_masuks')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('kategori_pemasukan_id','kategori_kas_masuk')->references('id')->on('kategori_pemasukans')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('arus_kas_masuk_kategori_pemasukan');
    }
}
