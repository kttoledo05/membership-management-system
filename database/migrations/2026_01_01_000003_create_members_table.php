<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();

            $table->string('membership_number')->unique();

            $table->foreignId('membership_category_id')
                ->constrained()
                ->restrictOnDelete();

            $table->foreignId('membership_level_id')
                ->constrained()
                ->restrictOnDelete();

            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone', 30);
            $table->text('address')->nullable();
            $table->date('birthdate')->nullable();

            $table->enum('status', [
                'active',
                'inactive',
            ])->default('active');

            $table->date('membership_start')->nullable();
            $table->date('membership_expiry')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};