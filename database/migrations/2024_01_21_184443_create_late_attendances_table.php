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
        Schema::create('late_attendances', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->time('from');
            $table->time('to');
            $table->longText('reason');
            $table->boolean('approved')->default(0);
            $table->text('reject_reason')->nullable();
            $table->timestamps();
            // $table->softDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('late_attendance');
    }
};
