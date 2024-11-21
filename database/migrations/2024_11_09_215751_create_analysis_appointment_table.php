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
        Schema::create('analysis_appointment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->constrained()->onDelete('cascade');
            $table->foreignId('analysis_id')->constrained()->onDelete('cascade');
            $table->decimal('price', 8, 2)->unsigned();
            $table->unsignedSmallInteger('quantity')->unsigned();
            $table->decimal('total_price', 9, 2)->unsigned();
            $table->enum('status', ['призначений', 'завершений'])->default('призначений');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analysis_appointment');
    }
};
