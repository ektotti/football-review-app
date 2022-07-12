<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFixturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        schema::create('fixtures', function(Blueprint $table){
            $table->bigIncrements('id');
            $table->integer('match_week');
            $table->string('hometeam_name');
            $table->string('awayteam_name');
            $table->dateTime('fixture_date_time');
            $table->mediumText('fixture_url');
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
        Schema::dropIfExists('fixtures');
    }
}
