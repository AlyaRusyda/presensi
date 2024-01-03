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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('api_token', 60);
            $table->timestamp('last_login_at')->nullable();
            $table->timestamp('logged_out_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};