<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarketTickersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('market_tickers', function (Blueprint $table) {
            $table->id();
            $table->string('symbol')->nullable();
            $table->string('price_change')->nullable();
            $table->string('price_change_percentage')->nullable();
            $table->string('weighted_average_price')->nullable();
            $table->string('open_time')->nullable();
            $table->string('close_time')->nullable();
            $table->string('number_of_trades')->nullable();
            $table->string('latest_price')->nullable();
            $table->string('dt')->nullable();
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
        Schema::dropIfExists('market_tickers');
    }
}
