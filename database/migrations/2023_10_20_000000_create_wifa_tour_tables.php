<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('type')->default('REGULER'); // VIP, PLUS, REGULER
            $table->date('departure_date');
            $table->date('return_date');
            $table->decimal('price', 15, 2);
            $table->integer('total_seats')->default(0);
            $table->integer('remaining_seats')->default(0);
            $table->string('hotel_mekkah')->nullable();
            $table->string('hotel_madinah')->nullable();
            $table->string('airline')->nullable();
            $table->date('manasik_date')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('itinerary_pdf')->nullable();
            $table->string('brosur_pdf')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });

        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('whatsapp');
            $table->string('status')->default('pending')->index(); // pending, contacted, closed, ordered, lunas
            $table->timestamps();
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code')->unique();
            $table->foreignId('package_id')->constrained()->onDelete('cascade');
            $table->foreignId('lead_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('total_amount', 15, 2);
            $table->string('payment_status')->default('unpaid')->index(); // unpaid, partial, paid
            $table->timestamps();
        });

        Schema::create('manifests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->string('full_name_passport')->nullable();
            $table->string('passport_number')->nullable()->index();
            $table->string('nik')->nullable()->index(); // Added NIK based on prompt
            $table->date('issuance_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->string('place_of_birth')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('phone')->nullable(); // Added Phone based on prompt
            $table->enum('gender', ['M', 'F'])->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('manifests');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('leads');
        Schema::dropIfExists('packages');
    }
};