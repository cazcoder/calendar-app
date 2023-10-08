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
        Schema::create('assigned_countries', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('country_id');
            $table->date('selected_date');
            $table->index('user_id');
            $table->index(['user_id', 'selected_date']);
            $table->primary(['user_id', 'country_id', 'selected_date']);
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assigned_countries');
    }
};
