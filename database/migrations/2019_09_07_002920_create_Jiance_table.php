<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJianceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Jiance', function (Blueprint $table) {
            $table->increments('id');
            $table->string('bianhao')->unique()->comment('合同编号');
            $table->json('pictures')->comment('扫描多图')->nullable();
            $table->string('beizhu')->comment('备注')->nullable();
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
        Schema::dropIfExists('Jiance');
    }
}
