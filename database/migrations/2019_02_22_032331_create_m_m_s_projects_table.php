<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMMSProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_m_s_projects', function (Blueprint $table) {
          $table->increments('id');
          $table->string('title');
          $table->date('pub_date');
          $table->string('slug');
          $table->longText('content');
          $table->string('images');
          $table->smallInteger('status');
          $table->string('metadesc');
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
        Schema::dropIfExists('m_m_s_projects');
    }
}
