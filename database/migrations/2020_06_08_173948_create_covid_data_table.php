<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCovidDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('covid_data', function (Blueprint $table) {
            $table->id();
            $table->integer('country_id')->unsigned();
            $table->bigInteger('total_confirmed')->unsigned();
            $table->bigInteger('total_deaths')->unsigned();
            $table->bigInteger('total_recovered')->unsigned();
            $table->date('date');
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
        Schema::dropIfExists('covid_data');
    }
}
