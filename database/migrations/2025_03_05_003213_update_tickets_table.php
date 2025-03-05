<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
            // Agregar la columna de "amount_paid"
            $table->decimal('amount_paid', 8, 2)->after('quantity');

            // Cambiar el valor predeterminado de 'status' a 'Activo'
            $table->string('status')->default('Activo')->change();
        });
    }

    public function down()
    {
        Schema::table('tickets', function (Blueprint $table) {
            // Eliminar la columna si se revierte la migración
            $table->dropColumn('amount_paid');

            // Revertir el valor predeterminado de 'status' a 'pending'
            $table->string('status')->default('pending')->change();
        });
    }
};
