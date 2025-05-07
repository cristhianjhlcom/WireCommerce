<?php

use App\Enums\CurrenciesCodeEnum;
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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('sku')->unique();
            $table->foreignId('color_id')->constrained()->onDelete('set null');
            $table->foreignId('size_id')->constrained()->onDelete('set null');
            $table->unsignedInteger('price');
            $table->unsignedInteger('sale_price')->nullable();
            $table->string('currency_code', 3)->default(CurrenciesCodeEnum::PEN->value);
            $table->string('image')->nullable();
            $table->enum('status', App\Enums\ProductsStatusEnum::values())->default(App\Enums\ProductsStatusEnum::DRAFT);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
