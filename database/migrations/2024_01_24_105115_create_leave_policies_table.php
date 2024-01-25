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
            $table->boolean('monthly')->default(false);
            $table->boolean('advance_salary')->default(false);
            $table->string('roles')->nullable();
            $table->string('gender')->nullable();
            $table->string('marital_status')->nullable();
            $table->enum('activate', ['manual', 'immediately_after_hiring']);
            $table->boolean('apply_existing_users')->default(false);
            $table->timestamps();
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
