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
        Schema::table('manifests', function (Blueprint $table) {
            $table->boolean('eq_koper')->default(false);
            $table->boolean('eq_ihram_mukena')->default(false);
            $table->boolean('eq_seragam_batik')->default(false);
            $table->boolean('eq_buku_panduan')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('manifests', function (Blueprint $table) {
            $table->dropColumn(['eq_koper', 'eq_ihram_mukena', 'eq_seragam_batik', 'eq_buku_panduan']);
        });
    }
};
