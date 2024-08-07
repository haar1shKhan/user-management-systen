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
        Schema::create('job_details', function (Blueprint $table) {
            $table->id();
            $table->date('hired_at')->nullable();
            $table->date('joined_at')->nullable();
            $table->date('resigned_at')->nullable();
            $table->dateTime('start_year')->nullable();
            $table->dateTime('end_year')->nullable();
            $table->enum('source_of_hire', ['direct', 'refaral', 'online'])->nullable();
            $table->enum('job_type', ['part_time', 'full_time', 'contract','internship','freelance'])->nullable();
            $table->enum('status', ['active', 'terminated', 'resigned','deceased'])->nullable();
            $table->integer('salary');
            $table->string('iban')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->enum('payment_method', ['cash', 'bank_transfer'])->nullable();
            $table->boolean('recived_email_notification')->default(0);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_details');
    }
};
