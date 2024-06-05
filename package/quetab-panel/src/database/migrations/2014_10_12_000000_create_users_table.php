<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $tableName;

    public function __construct(){
        $this->tableName = config('quetab.models.user.table');
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if(!Schema::hasTable($this->tableName)){
            Schema::create($this->tableName, function (Blueprint $table) {
                $table->id();
                $table->uuid('uuid')->unique()->nullable();
                $table->string('first_name')->nullable();
                $table->string('last_name')->nullable();
                $table->string('username')->unique();
                $table->string('email')->unique()->nullable();
                $table->string('status')->default('active');
                $table->timestamp('email_verified_at')->nullable();
                $table->timestamp('phone_verified_at')->nullable();
                $table->string('password');
                $table->boolean('password_needs_change')->default(false);
                $table->rememberToken();
                $table->softDeletes();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->tableName);
    }
};
