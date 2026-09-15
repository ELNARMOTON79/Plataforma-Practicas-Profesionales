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
        Schema::create('bitacora', function (Blueprint $table) {
            $table->id();
            $table->timestamp('timestamp')->useCurrent();
            $table->string('level', 20)->default('info'); // success, info, warning, danger
            $table->string('level_name', 50)->default('Info');
            $table->string('user', 255)->default('Sistema');
            $table->string('user_role', 100)->default('Sistema');
            $table->string('user_email', 255)->nullable();
            $table->string('module', 100);
            $table->string('action', 255);
            $table->text('description');
            $table->string('ip', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->json('payload')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bitacora');
    }
};
