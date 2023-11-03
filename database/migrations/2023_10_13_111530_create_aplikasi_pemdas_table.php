<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateAplikasiPemdasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aplikasi_pemdas', function (Blueprint $table) {
            $table->uuid('id')->primary();
			$table->string('nama')->nullable();
			$table->string('keterangan')->nullable();
			$table->string('jenis')->nullable();
			$table->string('link')->nullable();
			$table->foreignUuid('opd_id')->nullable()->constrained();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aplikasi_pemdas');
    }
}
