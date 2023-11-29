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
        Schema::create('points_redeemed', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('pharmacy_id');
            $table->unsignedBigInteger('points_added_id');
            $table->bigInteger('points');
            $table->date('day_redeemed');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('points_added_id')->references('id')->on('points_added');
            $table->foreign('pharmacy_id')->references('id')->on('pharmacies');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('points_redeemeds');
    }
};
