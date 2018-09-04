<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * DB migration: creates the initial tables
 */
class Start extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('phone', 50)->unique('phone')->comment('International format, digits only');
            $table->timestamps();
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('client_id')->index('client_id');
            $table->unsignedInteger('tariff_id')->index('tariff_id');
            $table->unsignedTinyInteger('start_day')->comment('Day of week as in ISO-8601');
            $table->text('address');
            $table->timestamps();
        });

        Schema::create('tariffs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->float('price', 10, 2)->unsigned()->index('price');
            $table->text('days')->comment('JSON');
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
        Schema::drop('clients');
        Schema::drop('orders');
        Schema::drop('tariffs');
    }
}
