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
        $table->string('name', 150);
        $table->string('sku', 50)->unique();
        $table->text('description')->nullable();

        $table->foreignId('category_id')->constrained()->restrictOnDelete();
        $table->foreignId('supplier_id')->nullable()->constrained()->nullOnDelete();

        $table->decimal('purchase_price', 10, 2);
        $table->decimal('selling_price', 10, 2);
        $table->unsignedInteger('quantity')->default(0);
        $table->unsignedInteger('reorder_level')->default(10);

        $table->timestamps();
        $table->softDeletes();
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
