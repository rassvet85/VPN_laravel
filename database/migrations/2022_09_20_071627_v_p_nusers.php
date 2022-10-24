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
        Schema::create('vpnusers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('create');
            $table->boolean('status')->nullable();
            $table->string('login')->nullable();
            $table->string('name')->nullable();
            $table->string('ipvpn')->nullable();
            $table->mediumText('vpnprofile')->nullable();
            $table->string('mail')->nullable();
            $table->boolean('wgprofile')->nullable();
            $table->boolean('emailsend')->nullable();
            $table->boolean('work')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::dropIfExists('vpnusers');
    }
};
