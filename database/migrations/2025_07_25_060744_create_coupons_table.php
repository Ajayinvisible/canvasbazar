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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->enum('type', ['percentage', 'fixed']); // Type of discount
            $table->decimal('value', 10, 2); // Discount value
            $table->decimal('min_order_amount', 10, 2)->default(0); // Minimum order to apply
            $table->decimal('max_discount', 10, 2)->nullable(); // Optional max cap for percentage
            $table->date('start_date'); // Valid from
            $table->date('end_date');   // Valid until
            $table->boolean('status')->default(true); // Active/inactive
            $table->boolean('one_time')->default(true); // If true, usable only once per user
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
