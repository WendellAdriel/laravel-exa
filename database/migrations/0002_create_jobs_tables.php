<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    private const string JOBS_TABLE = 'jobs';

    private const string JOB_BATCHES_TABLE = 'job_batches';

    private const string FAILED_JOBS_TABLE = 'failed_jobs';

    public function up(): void
    {
        if (! Schema::hasTable(self::JOBS_TABLE)) {
            Schema::create(self::JOBS_TABLE, function (Blueprint $table) {
                $table->id();
                $table->string('queue')->index();
                $table->longText('payload');
                $table->unsignedTinyInteger('attempts');
                $table->unsignedInteger('reserved_at')->nullable();
                $table->unsignedInteger('available_at');
                $table->unsignedInteger('created_at');
            });
        }

        if (! Schema::hasTable(self::JOB_BATCHES_TABLE)) {
            Schema::create(self::JOB_BATCHES_TABLE, function (Blueprint $table) {
                $table->string('id')->primary();
                $table->string('name');
                $table->integer('total_jobs');
                $table->integer('pending_jobs');
                $table->integer('failed_jobs');
                $table->longText('failed_job_ids');
                $table->mediumText('options')->nullable();
                $table->integer('cancelled_at')->nullable();
                $table->integer('created_at');
                $table->integer('finished_at')->nullable();
            });
        }

        if (! Schema::hasTable(self::FAILED_JOBS_TABLE)) {
            Schema::create(self::FAILED_JOBS_TABLE, function (Blueprint $table) {
                $table->id();
                $table->string('uuid')->unique();
                $table->text('connection');
                $table->text('queue');
                $table->longText('payload');
                $table->longText('exception');
                $table->timestamp('failed_at')->useCurrent();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists(self::JOBS_TABLE);
        Schema::dropIfExists(self::JOB_BATCHES_TABLE);
        Schema::dropIfExists(self::FAILED_JOBS_TABLE);
    }
};
