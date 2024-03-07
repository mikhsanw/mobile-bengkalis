<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateKimsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kims', function (Blueprint $table) {
            $table->uuid('id')->primary();
			$table->string('nama')->nullable();
			$table->string('alamat')->nullable();
			$table->text('keterangan')->nullable();
			$table->foreignUuid('wilayah_id')->nullable()->constrained();
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
        Schema::dropIfExists('kims');
    }
}
