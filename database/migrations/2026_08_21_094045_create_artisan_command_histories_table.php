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
        Schema::create('artisan_command_histories', function (Blueprint $table) {
            $table->id();

            $table->string('command');
            $table->text('parameters')->nullable();

            $table->enum('status', ['success', 'failed']);

            $table->longText('output')->nullable();

            $table->decimal('duration', 10, 2)->default(0);

            $table->unsignedInteger('exit_code')->nullable();

            $table->timestamps();

            $table->index('command');
            $table->index('status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artisan_command_histories');
    }
};