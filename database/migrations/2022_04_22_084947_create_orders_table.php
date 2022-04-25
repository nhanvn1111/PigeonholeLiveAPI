<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->integer('range_deli');
            $table->timestamp('deadline');
            $table->timestamp('time_end_deli');
            $table->timestamp('time_end_downtime')->nullable();
            $table->double('cost');
            $table->unsignedBigInteger('pigeonId');
            $table->foreign('pigeonId')->references('id')->on('pigeon');
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
        Schema::dropIfExists('orders');
    }
}
