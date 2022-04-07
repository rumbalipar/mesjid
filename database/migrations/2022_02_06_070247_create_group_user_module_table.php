<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupUserModuleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_user_module', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_user_id');
            $table->unsignedBigInteger('module_id');
            $table->enum('buat',['Y','N'])->default('N');
            $table->enum('ubah',['Y','N'])->default('N');
            $table->enum('hapus',['Y','N'])->default('N');
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
        Schema::dropIfExists('group_user_module');
    }
}
