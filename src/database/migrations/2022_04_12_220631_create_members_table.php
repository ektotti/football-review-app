<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('fixture_id');
            $table->string('team_name');
            $table->string('status');
            $table->string('player_1')->nullable();
            $table->string('player_2')->nullable();
            $table->string('player_3')->nullable();
            $table->string('player_4')->nullable();
            $table->string('player_5')->nullable();
            $table->string('player_6')->nullable();
            $table->string('player_7')->nullable();
            $table->string('player_8')->nullable();
            $table->string('player_9')->nullable();
            $table->string('player_10')->nullable();
            $table->string('player_11')->nullable();
            $table->string('player_12')->nullable();
            $table->string('player_13')->nullable();
            $table->string('player_14')->nullable();
            $table->string('player_15')->nullable();
            $table->string('player_16')->nullable();
            $table->string('player_17')->nullable();
            $table->string('player_18')->nullable();
            $table->string('player_19')->nullable();
            $table->string('player_20')->nullable();
            $table->timestamps();
            $table->foreign('fixture_id')->references('id')->on('fixtures');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
}
