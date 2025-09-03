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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('sender_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->foreignId('receiver_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->decimal('amount', 15, 2);
            $table->tinyInteger('status')->default(0)->comment('0: Pending, 1: Completed, 2: Failed');

            $table->index(['sender_id', 'receiver_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
