<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonthLevesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('month_leves', function (Blueprint $table) {
            $table->id();
          //  $table->bigIncrements('id');
          //  $table->integer('company_id')->unsigned();
           // $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade')->onUpdate('cascade');
           
            $table->string('month');
            $table->string('no');
            $table->string('sl');
            $table->string('cl');
            $table->string('status');
            
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
        Schema::dropIfExists('month_leves');
    }
}
