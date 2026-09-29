<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');                 // e.g. River Sand, Metal 3/4", Quarry Dust
            $table->string('name_si')->nullable();   // Sinhala name
            $table->string('unit')->default('Cube'); // Cube, Ton, Lorry, Bag, etc
            $table->decimal('unit_price', 12, 2);
            $table->decimal('stock_quantity', 12, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
