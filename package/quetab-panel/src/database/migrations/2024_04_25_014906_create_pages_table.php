<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    private $tableName;

    public function __construct(){
        $this->tableName = config('quetab.models.page.table');
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if(!Schema::hasTable($this->tableName)){
            Schema::create($this->tableName, function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->nullable();
                $table->string('title');
                $table->string('url');
                $table->longText('body')->nullable();
                $table->string('status')->default('published');
                $table->softDeletes();
                $table->timestamps();

                $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');

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
