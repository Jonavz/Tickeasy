<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('places', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location');
            $table->integer('max_capacity'); // Máximo de boletos disponibles
            $table->timestamps();
        });

        // Modificar tabla events para agregar la relación con places
        Schema::table('events', function (Blueprint $table) {
            $table->unsignedBigInteger('place_id')->after('category_id');
            $table->foreign('place_id')->references('id')->on('places')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign(['place_id']);
            $table->dropColumn('place_id');
        });

        Schema::dropIfExists('places');
    }
};
