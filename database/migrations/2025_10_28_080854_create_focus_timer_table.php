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
        Schema::create('focus_timer', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->integer('focus_time');
            $table->integer('break_time');
            $table->integer('section');
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('focus_timer');
    }
};
