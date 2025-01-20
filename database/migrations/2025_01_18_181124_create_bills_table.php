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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('flat_id')->constrained();
            $table->decimal('rent', 10, 2); // Rent bill amount
            $table->decimal('maintenance', 10, 2)->nullable(); // Maintenance bill amount
            $table->decimal('light_bill', 10, 2)->nullable(); // Light bill amount
            $table->date('bill_date'); // Date of the bill
            $table->boolean('paid')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
