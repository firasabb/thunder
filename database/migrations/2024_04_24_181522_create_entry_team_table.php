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
        Schema::create('entry_team', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('entry_id')->nullable();
            $table->unsignedBigInteger('team_id')->nullable();
            $table->string('conference')->nullable();
            $table->timestamps();

            $table->foreign('entry_id')->references('id')->on('entries')->onDelete('set null');
            $table->foreign('team_id')->references('id')->on('teams')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entry_team');
    }
};
