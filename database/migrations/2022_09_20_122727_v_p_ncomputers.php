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
        Schema::create('vpncomputers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('create');
            $table->boolean('status')->nullable();
            $table->string('login')->nullable();
            $table->string('comp')->nullable();
            $table->string('ipcompold')->nullable();
            $table->string('ipcomp')->nullable();
            $table->boolean('firewall')->nullable();
            $table->boolean('remotegroup')->nullable();
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
        //Schema::dropIfExists('vpncomputers');
    }
};
