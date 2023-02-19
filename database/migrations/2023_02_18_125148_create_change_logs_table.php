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
        Schema::create('change_logs', function (Blueprint $table) {
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

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('change_logs');
    }
};
