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
        Schema::create('buyers_requirements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('type')->nullable();
            $table->integer('bed_rooms')->nullable();
            $table->float('budget', 12, 2)->default(0);
            $table->float('area', 12, 2)->nullable();
            $table->tinyText('urgent_buy')->nullable();
            $table->text('location')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->default('Active');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buyers_requirements');
    }
};
