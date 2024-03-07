<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateKegiatanKimsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kegiatan_kims', function (Blueprint $table) {
            $table->uuid('id')->primary();
			$table->string('nama')->nullable();
			$table->string('lokasi')->nullable();
			$table->datetime('tanggal')->nullable();
			$table->boolean('jenis')->nullable();
			$table->longtext('deskripsi')->nullable();
			$table->foreignUuid('kim_id')->nullable()->constrained();
			$table->foreignUuid('kim_anggota_id')->nullable()->constrained();
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
        Schema::dropIfExists('kegiatan_kims');
    }
}
