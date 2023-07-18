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
        Schema::create('items', function (Blueprint $table) {
            $table->uuid('id')->unique();
            $table->string('name');
            $table->string('sku', 20);
            $table->string('total_stock', 5)->default(0);
            $table->integer('last_location')->nullable()->comment('last location of this item');
            $table->boolean('is_asset')->default(false);
            $table->integer('warehouse_id')->nullable();
            $table->string('merk')->nullable();
            $table->year('buy_year')->nullable();
            $table->float('price')->default(0)->comment('This is the last prices of this item');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
