<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('users', 'phone')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('phone', 20)->nullable()->after('email');
            });
        }

        if (! Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('role', 20)->default('donor')->after('password');
            });

            return;
        }

        Schema::table('users', function (Blueprint $table) {
            $table->string('role', 20)->default('donor')->change();
        });

        DB::table('users')->where('role', 'user')->update(['role' => 'donor']);
    }

    public function down(): void
    {
        $columnsToDrop = array_values(array_filter(
            ['phone', 'role'],
            fn (string $column): bool => Schema::hasColumn('users', $column),
        ));

        if ($columnsToDrop !== []) {
            Schema::table('users', function (Blueprint $table) use ($columnsToDrop): void {
                $table->dropColumn($columnsToDrop);
            });
        }
    }
};
