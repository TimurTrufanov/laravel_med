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
        Schema::create('appointment_analyses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->constrained()->onDelete('cascade');
            $table->foreignId('analysis_id')->constrained()->onDelete('cascade');
            $table->decimal('price', 8, 2)->unsigned();
            $table->unsignedSmallInteger('quantity')->unsigned();
            $table->decimal('total_price', 9, 2)->unsigned();
            $table->date('appointment_date')->nullable();
            $table->date('recommended_date')->nullable();
            $table->date('submission_date')->nullable();
            $table->string('file')->nullable();
            $table->enum('status', ['призначений', 'завершений'])->default('призначений');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointment_analyses');
    }
};
