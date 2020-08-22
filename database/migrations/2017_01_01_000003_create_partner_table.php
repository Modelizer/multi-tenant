<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartnerTable extends Migration
{
    public function up()
    {
        Schema::connection('default')
            ->create('partners', function (Blueprint $table) {
                $table->bigIncrements('id');

                $table->string('uuid')->unique();
                $table->string('name');

                $table->timestamps();
                $table->softDeletes();
            });
    }

    public function down()
    {
        Schema::dropIfExists('partners');
    }
}
