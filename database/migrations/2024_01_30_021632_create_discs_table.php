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
        Schema::create('discs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('album');
            $table->string('artist');
            $table->string('gender')->nullable();
            $table->string('year')->nullable();
            $table->string('picturealbum')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discs');
    }
};
