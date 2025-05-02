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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->longText('privacy_policy')->default('<p>privacy_policy not set</p>');
            $table->longText('cookie_policy')->default('<p>cookie_policy not set</p>');
            $table->longText('terms_conditions')->default('<p>terms_conditions not set</p>');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
