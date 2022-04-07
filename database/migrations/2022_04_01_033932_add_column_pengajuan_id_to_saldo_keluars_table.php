<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnPengajuanIdToSaldoKeluarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('saldo_keluars', function (Blueprint $table) {
            $table->unsignedBigInteger('pengajuan_id')->nullable(true)->default(null);
            $table->foreign('pengajuan_id')->references('id')->on('pengajuans')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('saldo_keluars', function (Blueprint $table) {
            $table->dropForeign('saldo_keluars_pengajuan_id_foreign');
            $table->dropColumn('pengajuan_id');
        });
    }
}
