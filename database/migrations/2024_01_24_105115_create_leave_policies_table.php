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
        Schema::create('leave_policies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('days');
            $table->integer('max_days')->default(0);
            $table->boolean('monthly')->default(false);
            $table->boolean('is_unlimited')->default(false);
            $table->boolean('advance_salary')->default(false);
            $table->string('roles')->nullable();
            $table->string('gender')->nullable();
            $table->string('marital_status')->nullable();
            $table->enum('activate', ['manual', 'immediately_after_hiring']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_policies');
    }
};
