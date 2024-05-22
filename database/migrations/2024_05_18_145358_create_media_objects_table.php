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
        Schema::create('media_objects', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('mediable_id')->nullable()->index();
            $table->string('mediable_type', 255)->nullable()->index();
            $table->string('filename', 255)->nullable();
            $table->string('url', 255)->nullable();
            $table->string('path', 255)->nullable();
            $table->string('thumbnail_url', 255)->nullable();
            $table->string('mime_type', 255)->nullable();
            $table->string('size', 255)->nullable();
            $table->string('title', 255)->nullable();
            $table->text('description')->nullable();
            $table->string('alt_text', 255)->nullable();
            $table->string('caption', 255)->nullable();
            $table->string('credit', 255)->nullable();
            $table->string('type', 255)->nullable();
            $table->string('status', 255)->nullable();
            $table->text('meta')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media_objects');
    }
};
