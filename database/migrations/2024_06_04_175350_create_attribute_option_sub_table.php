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
        Schema::create('attribute_option_sub', function (Blueprint $table) {
            $table->unsignedBigInteger('attribute_option_id');
            $table->unsignedBigInteger('attribute_option_sub_id');
            $table->foreign('attribute_option_id')->references('id')->on('attribute_options')->cascadeOnDelete();
            $table->foreign('attribute_option_sub_id')->references('id')->on('attribute_options')->cascadeOnDelete();
            $table->float('price');
            $table->integer('stock');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attribute_option_sub');
    }
};
