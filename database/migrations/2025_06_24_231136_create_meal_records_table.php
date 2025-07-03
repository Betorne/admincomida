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

        Schema::create('meal_records', function (Blueprint $table) {
        $table->id();
        $table->foreignId('worker_id')->constrained()->onDelete('cascade');
        $table->foreignId('service_type_id')->constrained()->onDelete('cascade');
        $table->timestamp('registered_at');
        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meal_records');
    }
};
