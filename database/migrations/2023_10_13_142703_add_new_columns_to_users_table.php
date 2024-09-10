<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('user_name')->nullable();
            $table->integer('country_id')->nullable();
            $table->string('mobile')->nullable();
            $table->enum('gender', ['male', 'female', 'third_gender'])->nullable();
            $table->string('address')->nullable();
            $table->string('website')->nullable();
            $table->enum('photo_storage', ['s3', 'public'])->nullable();
            $table->enum('user_type', ['user', 'admin'])->default('user');
            $table->enum('active_status', [0, 1, 2])->default(1);
            $table->enum('is_email_verified', [0, 1])->nullable();
            $table->string('activation_code')->nullable();
            $table->enum('is_online', [0, 1])->nullable();
            $table->timestamp('last_login')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
