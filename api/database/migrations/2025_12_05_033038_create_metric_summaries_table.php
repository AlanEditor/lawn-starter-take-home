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
        Schema::create('metric_summaries', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('average_duration_ms')
                ->default(0);
            $table->unsignedTinyInteger('peak_hour')
                ->nullable();
            $table->timestamp('sampling_start')
                ->nullable();
            $table->timestamp('sampling_end')
                ->nullable();
            $table->timestamp('calculation_time')
                ->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('metric_summaries');
    }
};
