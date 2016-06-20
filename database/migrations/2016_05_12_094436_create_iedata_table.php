<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIedataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ie_data', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('amount');
            $table->string('note');
            $table->integer('ie_by');
            $table->integer('ie_type');
            $table->integer('cat_id');
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
        Schema::drop('ie_data');
    }
}
