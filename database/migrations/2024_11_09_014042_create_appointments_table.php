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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('time_sheet_id')->constrained()->onDelete('cascade');
            $table->foreignId('doctor_id')->nullable()->constrained()->onDelete('cascade');
            $table->date('appointment_date');
            $table->enum('status', ['заплановано', 'завершено', 'скасовано'])->default('заплановано');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};