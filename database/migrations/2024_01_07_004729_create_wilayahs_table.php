<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wilayahs', function (Blueprint $table) {
            $table->uuid("id")->primary();
			$table->string("kode")->nullable();
			$table->string("nama")->nullable();
			$table->string("level")->nullable();
			$table->foreignUuid("parent_id")->nullable();
			$table->timestamps();
			$table->softDeletes();
        });

        Schema::table('wilayahs', function (Blueprint $table) {
            $table->foreign("parent_id")->references("id")->on("wilayahs")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wilayahs');
    }
};
