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
        Schema::create('user_bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('type');
            $table->string('meeting_link')->nullable();
            $table->string('duration');
            $table->date('booking_date')->nullable();
            $table->time('booking_time')->nullable();
            $table->time('end_time')->nullable();
            $table->text('message')->nullable();
            $table->string('status')->default('Active');
            $table->string('currency_symbol')->nullable();
            $table->string('currency_code')->nullable();
            $table->string('payment_status')->nullable();
            $table->float('payment_amount')->default(0);
            $table->string('payment_id')->nullable();
            $table->timestamp('payment_time')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_bookings');
    }
};
