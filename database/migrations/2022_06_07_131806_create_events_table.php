<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('content');
            $table->bigInteger('user_id');
            $table->bigInteger('event_type_id');
            $table->timestamps();

//            $table->foreign('user_id')
//                ->references('id')->on('users')->onDelete('cascade');
//            $table->foreign('event_type_id')->references('id')->on('event_types')->onDelete('cascade');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event_types', function (Blueprint $table){
            $table->foreign('user_id')
                ->references('id')->on('users')->onDelete('cascade');
            $table->foreign('event_type_id')->references('id')->on('event_types')->onDelete('cascade');
        });

        Schema::dropIfExists('events');
    }
}
