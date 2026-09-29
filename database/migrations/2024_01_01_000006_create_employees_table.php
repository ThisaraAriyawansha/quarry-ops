<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nic')->nullable();
            $table->string('phone')->nullable();
            $table->string('device_user_id')->unique()->nullable(); // ID registered on the RFID/attendance device
            $table->string('rfid_card_no')->nullable();
            $table->enum('pay_type', ['daily', 'hourly', 'monthly'])->default('daily');
            $table->decimal('daily_rate', 10, 2)->nullable();
            $table->decimal('hourly_rate', 10, 2)->nullable();
            $table->decimal('monthly_rate', 10, 2)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
