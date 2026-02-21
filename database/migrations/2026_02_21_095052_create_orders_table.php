<?php

use App\Enums\V1\OrderStatus;
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
            $table->id();
            $table->timestamps();
            $table->foreignId('car_id')->constrained('cars')->cascadeOnDelete();
            $table->string('service_type');
            $table->decimal('price');
            $table->enum('status', array_column(OrderStatus::cases(), 'value'))
                ->default(OrderStatus::PENDING->value);
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
