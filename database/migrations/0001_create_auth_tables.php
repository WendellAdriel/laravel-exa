<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Auth\Models\User;
use Modules\Auth\Models\UserLogin;

return new class() extends Migration
{
    private const string RESET_TOKENS_TABLE = 'password_reset_tokens';

    private const string SESSIONS_TABLE = 'sessions';

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

        if (! Schema::hasTable(UserLogin::getModelTable())) {
            Schema::create(UserLogin::getModelTable(), function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained();
                $table->string('ip', 50)->nullable();
                $table->string('user_agent')->nullable();
                $table->timestamps();
                $table->index(['user_id', 'created_at']);
            });
        }

        if (! Schema::hasTable(self::RESET_TOKENS_TABLE)) {
            Schema::create(self::RESET_TOKENS_TABLE, function (Blueprint $table) {
                $table->string('email')->primary();
                $table->string('token');
                $table->timestamp('created_at')->nullable();
            });
        }

        if (! Schema::hasTable(self::SESSIONS_TABLE)) {
            Schema::create(self::SESSIONS_TABLE, function (Blueprint $table) {
                $table->string('id')->primary();
                $table->foreignId('user_id')->nullable()->index();
                $table->string('ip_address', 45)->nullable();
                $table->text('user_agent')->nullable();
                $table->longText('payload');
                $table->integer('last_activity')->index();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists(User::getModelTable());
        Schema::dropIfExists(UserLogin::getModelTable());
        Schema::dropIfExists(self::RESET_TOKENS_TABLE);
        Schema::dropIfExists(self::SESSIONS_TABLE);
    }
};
