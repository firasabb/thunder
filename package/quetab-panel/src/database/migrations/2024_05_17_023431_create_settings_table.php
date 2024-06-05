<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Quetab\QuetabPanel\Models\Setting;

return new class extends Migration
{

    public function __construct(){
        $this->tableName = config('quetab.models.setting.table');
    }
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable($this->tableName)) {
            Schema::create('settings', function (Blueprint $table) {
                $table->id();
                $table->uuid('uuid')->unique()->nullable();
                $table->unsignedBigInteger('user_id')->nullable();
                $table->unsignedBigInteger('settingable_id')->nullable()->index();
                $table->string("settingable_type")->nullable()->index();
                $table->string('name', 255)->nullable();
                $table->longText('value')->nullable();
                $table->softDeletes();
                $table->timestamps();

                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
