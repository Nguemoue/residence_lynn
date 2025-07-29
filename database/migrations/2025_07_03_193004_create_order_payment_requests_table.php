<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('order_payment_requests', static function (Blueprint $table) {
            $table->id();
            $table->string('payment_reference')->unique();
            $table->string('payer_name');
            $table->string('payer_email');
            $table->string('payer_address');
            $table->string('payer_phone');
            $table->string('payer_city');
            $table->string('payer_postal_code');
            $table->string('payer_surname');
            $table->string('payment_method');
            $table->json('metadata')->nullable();
            $table->json('payment_metadata')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_payment_requests');
    }
};
