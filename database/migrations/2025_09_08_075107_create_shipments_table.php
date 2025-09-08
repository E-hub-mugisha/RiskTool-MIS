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
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('allocation_id')->constrained('resource_allocations')->cascadeOnDelete();
            $table->string('tracking_number')->unique();
            $table->foreignId('shipped_by')->constrained('staff')->cascadeOnDelete();
            $table->enum('status', ['in_transit','delivered','failed'])->default('in_transit');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
