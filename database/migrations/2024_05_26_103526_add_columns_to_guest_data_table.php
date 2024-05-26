<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('guest_data', function (Blueprint $table) {
            $table->string('plataforma', 2)->nullable();
            $table->string('navegador', 10)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('guest_data', function (Blueprint $table) {
            $table->dropColumn('navegador');
            $table->dropColumn('plataforma');
        });
    }
};
