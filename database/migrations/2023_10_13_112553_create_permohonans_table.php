<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreatePermohonansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permohonans', function (Blueprint $table) {
            $table->uuid('id')->primary();
			$table->string('no_identitas')->nullable();
			$table->string('nama')->nullable();
			$table->string('alamat')->nullable();
			$table->string('email')->nullable();
			$table->string('no_telp',15)->nullable();
			$table->string('pekerjaan')->nullable();
			$table->string('rincian_informasi')->nullable();
			$table->string('tujuan_penggunaan')->nullable();
			$table->foreignUuid('opd_id')->nullable()->constrained();
			$table->string('cara_memperoleh')->nullable();
			$table->string('salinan_informasi')->nullable();
			$table->string('cara_mendapatkan')->nullable();
			$table->string('jenis_pemohon')->nullable();
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
        Schema::dropIfExists('permohonans');
    }
}
