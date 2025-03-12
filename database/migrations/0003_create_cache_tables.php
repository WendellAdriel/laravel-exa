<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    private const string CACHE_TABLE = 'cache';

    private const string CACHE_LOCKS_TABLE = 'cache_locks';

    public function up(): void
    {
        if (! Schema::hasTable(self::CACHE_TABLE)) {
            Schema::create(self::CACHE_TABLE, function (Blueprint $table) {
                $table->string('key')->primary();
                $table->mediumText('value');
                $table->integer('expiration');
            });
        }

        if (! Schema::hasTable(self::CACHE_LOCKS_TABLE)) {
            Schema::create(self::CACHE_LOCKS_TABLE, function (Blueprint $table) {
                $table->string('key')->primary();
                $table->string('owner');
                $table->integer('expiration');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists(self::CACHE_TABLE);
        Schema::dropIfExists(self::CACHE_LOCKS_TABLE);
    }
};
