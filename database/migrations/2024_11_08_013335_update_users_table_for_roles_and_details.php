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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->string('first_name');
            $table->string('last_name');
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['чоловічий', 'жіночий'])->nullable();
            $table->string('address')->nullable();
            $table->string('phone_number', 10)->nullable();
            $table->string('photo')->nullable();
            $table->foreignId('role_id')->nullable()->constrained()->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->nullable();
            $table->dropColumn(['first_name', 'last_name', 'date_of_birth', 'gender', 'phone', 'role_id']);
        });
    }
};
