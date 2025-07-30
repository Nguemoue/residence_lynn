<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('accommodations', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->text("description")->nullable();
            $table->foreignId('accommodation_type_id')->constrained('accommodation_types');
            $table->string("cover_image")->nullable();
            $table->boolean('is_available')->default(true);
            $table->json('gallery')->nullable();
            $table->json('amenities')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accommodations');
    }
};
