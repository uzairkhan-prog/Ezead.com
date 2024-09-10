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
            $table->string('image')->nullable();
            $table->string('profile_background')->nullable();
            $table->string('service_city')->nullable();
            $table->string('service_area')->nullable();
            $table->integer('user_status')->default(1)->comment('0=inactive, 1=active');
            $table->integer('terms_condition')->default(1);
            $table->string('state')->nullable();
            $table->string('post_code')->nullable();
            $table->string('email_verified')->nullable();
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
