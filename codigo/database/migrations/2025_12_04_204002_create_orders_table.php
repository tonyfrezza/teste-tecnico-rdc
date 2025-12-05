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
        Schema::create('orders', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->string('customer_name');
            $table->enum('status', ['draft', 'pending', 'paid', 'cancelled'])->default('draft');
            $table->decimal('subtotal', 10);
            $table->decimal('discount', 10)->nullable();
            $table->decimal('tax', 10)->nullable();
            $table->decimal('total', 10);
            $table->json('notes')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
