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
            $table->foreignId('shopId')->constrained('shops')
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('name');
            $table->text('information');
            $table->unsignedInteger('price');
            $table->boolean('isSelling');
            $table->integer('sortOrder')->nullable();
            $table->integer('stock');
            $table->foreignId('secondaryId')->constrained('secondary_categories');
            $table->foreignId('image1')->nullable()->constrained('images');
            $table->foreignId('image2')->nullable()->constrained('images');
            $table->foreignId('image3')->nullable()->constrained('images');
            $table->foreignId('image4')->nullable()->constrained('images');
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
