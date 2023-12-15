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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code');
            $table->string('client_order_code');
            $table->string('order_comments');
            $table->integer('dropshipping');
            $table->string('send_to_name');
            $table->string('send_to_address');
            $table->string('send_to_zipcode');
            $table->string('send_to_village_neighborhood');
            $table->string('send_to_city');
            $table->string('send_to_phone_number');
            $table->string('send_to_person');
            $table->integer('transport_code');
            $table->integer('delivery_note_type');
            $table->integer('packaging_type');
            $table->string('order_code_nav')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('shipping')->nullable();
            $table->integer('status_nav')->nullable();
            $table->string('status_text')->nullable();
            $table->string('tracking_number')->nullable();
            $table->integer('status');
            $table->string('user');
            $table->timestamps();
            $table->dateTime('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
