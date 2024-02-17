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
        Schema::table('long_leaves', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('entitlement_id')->nullable();
            $table->foreign('entitlement_id')->references('id')->on('leave_entitlements')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('long_leaves', function (Blueprint $table) {
            //
        });
    }
};
