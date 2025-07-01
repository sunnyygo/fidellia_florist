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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('flower_id')->constrained()->onDelete('cascade');
            $table->foreignId('flower_color_id')->constrained('colors')->onDelete('cascade');
            $table->foreignId('background_color_id')->constrained('colors')->onDelete('cascade');
            $table->foreignId('list_color_id')->constrained('colors')->onDelete('cascade');
            $table->text('address');
            $table->decimal('total_price', 10, 2);
            $table->enum('status', ['unpaid', 'paid'])->default('Pending');
            $table->enum('status_order', ['pending', 'batal', 'selesai'])->default('pending');
            $table->string('image_url')->nullable();
            $table->foreignId('transaction_id')->nullable()->constrained()->onDelete('cascade');
            $table->text('kalimat');
            $table->timestamps();
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
