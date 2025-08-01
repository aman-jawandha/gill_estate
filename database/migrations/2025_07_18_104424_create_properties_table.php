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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('features')->nullable();
            $table->float('price', 12, 2)->default(0);
            $table->string('type')->nullable();
            $table->string('status')->default('Pending');
            $table->text('reason')->nullable();
            $table->string('built_year')->nullable();
            $table->integer('bed_rooms')->nullable();
            $table->integer('bath_rooms')->nullable();
            $table->float('area', 12, 2)->nullable(); // size in sq ft
            $table->integer('floor_number')->nullable();
            $table->integer('total_floors')->nullable();
            $table->string('furnishing')->nullable();
            $table->string('street')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('zip_code')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('user_role')->nullable();
            $table->string('banner_image')->nullable();
            $table->tinyText('urgent_sell')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
