<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::table('records', function (Blueprint $table): void {
            $table->timestamp('password_last_changed')->nullable();
            $table->integer('password_expiry_days')->default(90); // Default 90 days expiry
        });
    }

    public function down(): void
    {
        Schema::table('records', function (Blueprint $table): void {
            $table->dropColumn(['password_last_changed', 'password_expiry_days']);
        });
    }
};
