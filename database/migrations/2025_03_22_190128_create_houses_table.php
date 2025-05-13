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
        Schema::create('houses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->unsignedBigInteger('owner_id')->nullable();
            $table->foreign('tenant_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
            $table->double('price')->default(0);
            $table->date('payment_date')->nullable();
            $table->text('address');
            $table->double('latitude')->default(0);
            $table->double('longitude')->default(0);
            $table->longText('description');
            $table->text('privateNotes')->nullable();
            $table->integer('area')->default(0);
            $table->unsignedInteger('rooms')->default(1);
            $table->boolean('rented')->default(0);
            $table->json('amenities')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('houses');
    }
};
