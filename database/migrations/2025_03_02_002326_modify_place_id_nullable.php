<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->unsignedBigInteger('place_id')->nullable()->change(); // ✅ Permite valores NULL
        });
    }

    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->unsignedBigInteger('place_id')->nullable(false)->change(); // Revertir en caso de rollback
        });
    }
};
