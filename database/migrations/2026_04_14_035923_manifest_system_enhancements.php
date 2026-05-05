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
        Schema::create('room_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->constrained()->onDelete('cascade');
            $table->string('hotel_name')->nullable();
            $table->string('room_number')->nullable();
            $table->string('room_type')->default('Double'); // Quad, Triple, Double
            $table->timestamps();
        });

        Schema::table('manifests', function (Blueprint $table) {
            $table->renameColumn('full_name_passport', 'full_name');
            $table->string('family_name')->nullable();
            $table->renameColumn('issuance_date', 'date_of_issue');
            $table->renameColumn('expiry_date', 'date_of_expiry');
            $table->string('issuing_office')->nullable();
            $table->renameColumn('birth_date', 'date_of_birth');
            $table->renameColumn('phone', 'phone_number');
            $table->foreignId('room_list_id')->nullable()->constrained('room_lists')->nullOnDelete();
        });

        Schema::create('bus_seaters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('manifest_id')->constrained('manifests')->onDelete('cascade');
            $table->string('bus_number')->nullable();
            $table->string('seat_number')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bus_seaters');
        
        Schema::table('manifests', function (Blueprint $table) {
            $table->dropForeign(['room_list_id']);
            $table->dropColumn('room_list_id');
            $table->renameColumn('full_name', 'full_name_passport');
            $table->dropColumn('family_name');
            $table->renameColumn('date_of_issue', 'issuance_date');
            $table->renameColumn('date_of_expiry', 'expiry_date');
            $table->dropColumn('issuing_office');
            $table->renameColumn('date_of_birth', 'birth_date');
            $table->renameColumn('phone_number', 'phone');
        });

        Schema::dropIfExists('room_lists');
    }
};
