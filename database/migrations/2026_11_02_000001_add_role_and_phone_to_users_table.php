<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * This legacy migration duplicates the later canonical users migration.
     * Keep it as a no-op because some databases may already have recorded it.
     */
    public function up(): void {}

    public function down(): void {}
};
