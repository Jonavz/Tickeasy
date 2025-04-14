<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->foreignId('place_id')->constrained()->onDelete('cascade'); // 🔄 Relación con lugar
            $table->unsignedBigInteger('category_id');
            $table->string('logo_image')->nullable();
            $table->date('fecha_de_inicio');
            $table->date('fecha_finalizacion');
            $table->integer('available_tickets')->default(0);
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });

    }

    public function down()
    {
        Schema::dropIfExists('events');
    }
};
