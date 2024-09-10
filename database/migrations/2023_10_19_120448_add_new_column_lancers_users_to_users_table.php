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
            $table->string('uid', 20)->unique()->nullable();
            $table->enum('account_type', ['seller', 'buyer'])->default('buyer');
            $table->unsignedBigInteger('avatar_id')->nullable();
            $table->unsignedBigInteger('level_id')->nullable();
            $table->string('provider_name', 60)->nullable();
            $table->string('fullname', 60)->nullable();
            $table->string('headline', 100)->nullable();
            $table->text('description')->nullable();
            $table->enum('l_status', ['active', 'pending', 'verified', 'banned'])->default('pending');
            $table->string('balance_net', 20)->default(0);
            $table->string('balance_withdrawn', 20)->default(0);
            $table->string('balance_purchases', 20)->default(0);
            $table->string('balance_pending', 20)->default(0);
            $table->string('balance_available', 20)->default(0);
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
