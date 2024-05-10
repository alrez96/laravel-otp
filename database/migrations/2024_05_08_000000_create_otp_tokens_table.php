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
        Schema::create(config('otp.token_table', 'otp_tokens'), function (Blueprint $table) {
            $table->id();
            $table->string('identifier')->index();
            $table->string('token');
            $table->timestamp('expired_at');
            $table->timestamp('used_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('otp.token_table', 'otp_tokens'));
    }
};
