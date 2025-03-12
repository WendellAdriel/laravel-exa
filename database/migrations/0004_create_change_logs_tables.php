<?php

declare(strict_types=1);

use Exa\Models\ChangeLog;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable(ChangeLog::getModelTable())) {
            Schema::create(ChangeLog::getModelTable(), function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained();
                $table->bigInteger('record_id');
                $table->string('table');
                $table->string('action', 50);
                $table->json('payload');
                $table->json('old_data')->nullable();
                $table->json('new_data')->nullable();
                $table->json('changed_data')->nullable();
                $table->timestamps();
                $table->index(['table', 'record_id', 'created_at']);
                $table->index(['table', 'record_id', 'action', 'created_at']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists(ChangeLog::getModelTable());
    }
};
