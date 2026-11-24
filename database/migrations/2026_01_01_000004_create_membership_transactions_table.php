<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration { public function up(): void { Schema::create('membership_transactions', function (Blueprint $table) { $table->id(); $table->foreignId('member_id')->constrained()->cascadeOnDelete(); $table->string('reference_number')->unique(); $table->enum('type', ['application', 'renewal']); $table->enum('status', ['pending', 'paid', 'approved', 'expired', 'cancelled'])->default('pending'); $table->decimal('amount', 10, 2); $table->date('transaction_date'); $table->text('remarks')->nullable(); $table->timestamps(); }); } public function down(): void { Schema::dropIfExists('membership_transactions'); } };
