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
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name', 255)->nullable();
            $table->string('slug', 255)->nullable();
            $table->string('abbreviation', 255)->nullable();
            $table->string('url', 255)->nullable();
            $table->string('short_description', 255)->nullable();
            $table->text('description')->nullable();
            $table->string('logo_url', 255)->nullable();
            $table->string('status', 255)->nullable();
            $table->string('city', 255)->nullable();
            $table->string('state', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
