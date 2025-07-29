<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('accommodation_types', static function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->string('cover_image')->nullable();
            $table->string('description');
            $table->float('price_per_night');
            $table->boolean('is_available');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accommodation_types');
    }
};
