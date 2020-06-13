<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ename')->unique();
            $table->string('aname');
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('sub_category_id');
            $table->integer('no_orders');
            $table->tinyInteger('status');
            $table->string('image');
            $table->string('edescription');
            $table->string('description');
            $table->string('suger_spons');
            $table->string('quantity');
            $table->string('extra_ice');
            $table->string('temperature');
            $table->tinyInteger('featured');
            $table->timestamps();

            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');

            $table->foreign('sub_category_id')
                ->references('id')
                ->on('categories')
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
        Schema::dropIfExists('items');
    }
}
