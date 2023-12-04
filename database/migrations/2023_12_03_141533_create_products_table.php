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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\ProductCategory::class)->nullable();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('image');
            $table->string('description');
            $table->float('price');
            $table->enum('status', \App\Enums\StatusProduct::lowercaseOptions());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
