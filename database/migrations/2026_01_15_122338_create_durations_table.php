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
        Schema::create('durations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('fifteen_minutes')->default('Yes');
            $table->string('thiry_minutes')->default('No');
            $table->string('fortyfive_minutes')->default('No');
            $table->string('sixty_minutes')->default('No');
            $table->float('15 minutes')->default(0);
            $table->float('30 minutes')->default(0);
            $table->float('45 minutes')->default(0);
            $table->float('60 minutes')->default(0);
            $table->string('online_booking')->default('Yes');
            $table->string('face_to_face')->default('No');
            $table->string('available')->default('Yes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('durations');
    }
};
