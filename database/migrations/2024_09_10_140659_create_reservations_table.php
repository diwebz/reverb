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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('res_no')->unique();
            $table->string('res_name');
            $table->integer('res_count')->nullable();
            $table->date('res_date');
            $table->time('res_time')->nullable();
            $table->string('res_phone');
            $table->string('res_email')->nullable();
            $table->text('res_notes')->nullable();
            $table->string('res_status')->default('Received');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
