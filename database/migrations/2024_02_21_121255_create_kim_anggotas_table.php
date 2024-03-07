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
        Schema::create('kim_anggotas', function (Blueprint $table) {
            $table->uuid('id')->primary();
			$table->tinyInteger('level_kim')->nullable();
			$table->foreignUuid('kim_id')->nullable()->constrained();
			$table->foreignUuid('user_id')->nullable()->constrained();
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
        Schema::dropIfExists('kim_anggotas');
    }
};
