<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Auth\Models\User;

return new class() extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasTable(User::getModelTable())) {
            Schema::create(User::getModelTable(), function (Blueprint $table) {
                $table->id();
                $table->uuid();
                $table->string('name');
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->string('role');
                $table->boolean('active')->default(true);
                $table->rememberToken();
                $table->timestamps();
                $table->softDeletes();
                $table->userActions();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(User::getModelTable());
    }
};
