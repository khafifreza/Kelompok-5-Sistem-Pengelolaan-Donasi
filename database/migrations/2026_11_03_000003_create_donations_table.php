<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained()->restrictOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('invoice')->unique();
            $table->string('donor_name');
            $table->string('donor_email')->nullable();
            $table->unsignedBigInteger('amount');
            $table->text('message')->nullable();
            $table->boolean('is_anonymous')->default(false);
            $table->string('status', 20)->default('pending')->index();
            $table->timestamp('paid_at')->nullable()->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
