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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->timestamp('phone_verified_at')->nullable();
            $table->string('password');
            $table->text('greetings')->nullable();
            $table->text('address')->nullable();
            $table->text('city')->nullable();
            $table->text('house_number')->nullable();
            $table->text('employment')->nullable();
            $table->unsignedTinyInteger('family_members')->nullable();
            $table->unsignedTinyInteger('kids')->nullable();
            $table->text('nid_number')->nullable();
            $table->string('contact_number', 20)->unique();
            $table->boolean('status')->default(0)->comment('Active = true, Inactive = false');
            $table->enum('role', [USER_ROLE_OWNER,USER_ROLE_TENANT,USER_ROLE_ADMIN]);
            $table->tinyText('locale')->default('en');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
