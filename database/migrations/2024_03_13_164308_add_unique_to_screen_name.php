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
        Schema::dropColumns('screen', ['name']);
        Schema::table('screen', function (Blueprint $table) {
           $table->string('name')->unique()->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
