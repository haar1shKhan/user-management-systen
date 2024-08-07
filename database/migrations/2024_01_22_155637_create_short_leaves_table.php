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
        Schema::create('short_leaves', function (Blueprint $table) {

            $table->id();
            $table->timestamp('date');
            $table->time('from');
            $table->time('to');
            $table->longText('reason')->nullable();
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
        Schema::dropIfExists('short_leaves');
    }
};
