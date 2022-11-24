<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseNumber extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_number', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('address_sid')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('phone_number')->nullable();
            $table->longText('voice_url')->nullable();
            $table->longText('sms_url')->nullable();
            $table->string('street')->nullable();
            $table->string('city')->nullable();
            $table->string('region')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('country_code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_number');
    }
}
