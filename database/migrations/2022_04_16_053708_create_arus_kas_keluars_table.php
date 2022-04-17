<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArusKasKeluarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arus_kas_keluars', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('arus_kas_id');
            $table->integer('seq')->default('1');
            $table->string('deskripsi');
            $table->timestamps();

            $table->foreign('arus_kas_id')->references('id')->on('arus_kas')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('arus_kas_keluars');
    }
}
