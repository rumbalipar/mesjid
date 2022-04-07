<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('website')->nullable(true)->default(null);
            $table->text('alamat')->nullable(true)->default(null);
            $table->string('logo')->nullable(true)->default(null);
            $table->string('pemilik')->nullable(true)->default(null);
            $table->date('tanggal_berdiri')->nullable(true)->default(null);
            $table->string('telepon')->nullable(true)->default(null);
            $table->string('email')->nullable(true)->default(null);
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
        Schema::dropIfExists('company_profiles');
    }
}
