<?php

declare(strict_types=1);

use App\Models\Domain;
use App\Models\RecordType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create('records', function (Blueprint $table): void {
            $table->id();
            $table
                ->foreignIdFor(RecordType::class)
                ->constrained('record_types')
                ->cascadeOnDelete();
            $table->string('url');
            $table->string('username');
            $table->text('password');
            $table
                ->foreignIdFor(Domain::class)
                ->constrained('domains')
                ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('records');
    }
};
