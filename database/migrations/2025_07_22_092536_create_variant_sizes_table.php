<?php

use App\Models\Variant;
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
        Schema::create('variant_sizes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Variant::class)->constrained()->onDelete('cascade');
            $table->string('size_label');
            $table->decimal('price', 10, 2)->default(0.00);
            $table->integer('stock')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variant_sizes');
    }
};
