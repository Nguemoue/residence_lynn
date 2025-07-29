<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table): void {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string("code")->nullable();
            $table->string('email');
            $table->string('phone');
            $table->string('full_name');
            $table->string('address_line1');
            $table->string('address_line2')->nullable();
            $table->string('city');
            $table->foreignId('order_payment_request_id')->nullable()->constrained()->nullOnDelete();
            $table->string('postal_code');
            $table->string('country', 2)->default('FR');
            $table->string('status', 20)->default('received');
            $table->json('status_note')->nullable();
            $table->string('stripe_payment_intent')->nullable();
            $table->decimal('subtotal', 10, 2);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->json("payment_metadata")->nullable();
            $table->decimal('shipping_total', 10, 2)->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
