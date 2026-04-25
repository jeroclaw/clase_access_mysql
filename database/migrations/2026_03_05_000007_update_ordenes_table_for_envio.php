<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('ordenes', function (Blueprint $table) {
            $table->boolean('envio')->default(false)->after('total');
            $table->dropColumn('estado');
        });

        // Actualiza los registros existentes para que el campo 'envio' sea 0 (false).
        DB::table('ordenes')->update(['envio' => false]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ordenes', function (Blueprint $table) {
            $table->string('estado', 20)->after('total')->default('pendiente');
            $table->dropColumn('envio');
        });
    }
};
