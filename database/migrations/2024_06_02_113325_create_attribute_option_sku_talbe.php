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
        Schema::create('attribute_option_sku', function (Blueprint $table) {
            $table->unsignedBigInteger('attribute_options_id');
            $table->unsignedBigInteger('sku_id');
            $table->foreign('attribute_options_id')->references('id')->on('attribute_options')->cascadeOnDelete();
            $table->foreign('sku_id')->references('id')->on('skus')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attribute_option_sku_talbe');
    }
};
