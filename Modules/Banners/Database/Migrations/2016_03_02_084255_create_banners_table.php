<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBannersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('caption')->nullable();
            $table->string('image');
            $table->text('body')->nullable();
            $table->string('link')->nullable();
            $table->string('link_label')->nullable();
            $table->boolean('status');
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
        Schema::drop('banners');
    }

}
