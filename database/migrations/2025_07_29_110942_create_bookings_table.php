<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('bookings', static function (Blueprint $table) {
            $table->id();
            $table->date('start_date');
            $table->date('end_date');
            $table->string("email");
            $table->string("phone");
            $table->string("name");
            $table->integer('guest_number');
            $table->enum('status',array_column(\App\Domain\Enums\BookingStatusEnum::cases(), 'value'))->default(\App\Domain\Enums\BookingStatusEnum::PENDING->value);
            $table->foreignId('accommodation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bookings');
    }
};
