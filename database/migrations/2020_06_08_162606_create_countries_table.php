<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->string('slug');
            $table->bigInteger('total_confirmed')->unsigned()->default(0);
            $table->bigInteger('new_confirmed')->unsigned()->default(0);
            $table->bigInteger('total_deaths')->unsigned()->default(0);
            $table->bigInteger('new_deaths')->unsigned()->default(0);
            $table->bigInteger('total_recovered')->unsigned()->default(0);
            $table->bigInteger('new_recovered')->unsigned()->default(0);
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
        Schema::dropIfExists('countries');
    }
}
