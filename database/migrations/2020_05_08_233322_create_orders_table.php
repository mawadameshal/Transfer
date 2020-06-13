<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id_sender');
            $table->unsignedInteger('user_id_receiver');
            $table->unsignedInteger('deliver_to');
            $table->string('deliver_at');
            $table->date('order_date');
            $table->time('order_time');
            $table->tinyInteger('status')->default(0);
            $table->timestamps();


            $table->foreign('user_id_sender')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('user_id_receiver')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('deliver_to')
                ->references('id')
                ->on('offices')
                ->onDelete('cascade');
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
}
