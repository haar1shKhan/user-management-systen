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
        Schema::create('long_leaves', function (Blueprint $table) {
            $table->id();
            $table->date('from');
            $table->date('to');
            $table->longText('reason');
            $table->boolean('salary')->default(0);
            $table->string('leave_file')->nullable();
            $table->boolean('approved')->default(0);
            $table->text('reject_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('long_leaves');
    }
};
