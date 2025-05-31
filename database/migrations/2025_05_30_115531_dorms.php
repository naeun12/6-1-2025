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
        Schema::create('dorms', function (Blueprint $table) {

        $table->id('dorm_id');
        $table->string('dorm_name');
        $table->string('landlord_id', 255);
                $table->text('address');
        $table->decimal('latitude', 10, 8);
        $table->decimal('longitude', 11, 8);
        $table->text('description')->nullable();
        $table->text('amenities')->nullable();
        $table->integer('total_rooms');
        $table->integer('available_rooms');
        $table->string('contact_email');
        $table->string('contact_phone');
        $table->text('rules')->nullable();
        $table->string('google_maps_link')->nullable();
        $table->timestamps();
        $table->foreign('landlord_id')->references('landlord_id')->on('landlords')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dorms');

    }
};