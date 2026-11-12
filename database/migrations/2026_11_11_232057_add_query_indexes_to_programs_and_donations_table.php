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
        Schema::table('donations', function (Blueprint $table) {
            $table->index('user_id');
            $table->index(['program_id', 'status']);
            $table->index('created_at');
        });

        Schema::table('programs', function (Blueprint $table) {
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->dropIndex('donations_user_id_index');
            $table->dropIndex('donations_program_id_status_index');
            $table->dropIndex('donations_created_at_index');
        });

        Schema::table('programs', function (Blueprint $table) {
            $table->dropIndex('programs_created_at_index');
        });
    }
};
