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
            $table->string('marital_status')->default('Lajang')->after('gender'); // Lajang, Nikah, Cerai, Janda/Duda
            
            // File Paths
            $table->string('passport_scan')->nullable()->after('date_of_expiry');
            $table->string('photo_scan')->nullable()->after('passport_scan');
            $table->string('nik_scan')->nullable()->after('photo_scan');
            $table->string('buku_nikah_scan')->nullable()->after('nik_scan');
            
            // Status Flags
            $table->boolean('doc_passport_ok')->default(false)->after('buku_nikah_scan');
            $table->boolean('doc_photo_ok')->default(false)->after('doc_passport_ok');
            $table->boolean('doc_nik_ok')->default(false)->after('doc_photo_ok');
            $table->boolean('doc_buku_nikah_ok')->default(false)->after('doc_nik_ok');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('manifests', function (Blueprint $table) {
            $table->dropColumn([
                'marital_status',
                'passport_scan',
                'photo_scan',
                'nik_scan',
                'buku_nikah_scan',
                'doc_passport_ok',
                'doc_photo_ok',
                'doc_nik_ok',
                'doc_buku_nikah_ok'
            ]);
        });
    }
};
