<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengajuanStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengajuan_statuses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pengajuan_id');
            $table->enum('status',['Approve','Not Approve'])->nullable(true)->default(null);
            $table->date('tanggal')->nullable(true)->default(null);
            $table->time('jam')->nullable(true)->default(null);
            $table->text('keterangan')->nullable(true)->default(null);
            $table->unsignedBigInteger('user_id')->nullable(true)->default(null);
            $table->timestamps();

            $table->foreign('pengajuan_id')->references('id')->on('pengajuans')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengajuan_statuses');
    }
}
