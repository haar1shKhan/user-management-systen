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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();//
            $table->string('nationality')->nullable();
            $table->string('religion')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('biography',800)->nullable();
            $table->string('address')->nullable();
            $table->string('address2')->nullable();//
            $table->string('city')->nullable();//
            $table->string('province')->nullable();//
            $table->string('country')->nullable();//

            
            $table->string('passport')->nullable();//
            $table->date('passport_issued_at')->nullable();//
            $table->date('passport_expires_at')->nullable();//
            $table->string('nid')->nullable();//
            $table->date('nid_issued_at')->nullable();//
            $table->date('nid_expires_at')->nullable();//
            $table->string('visa')->nullable();//
            $table->date('visa_issued_at')->nullable();//
            $table->date('visa_expires_at')->nullable();//
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
