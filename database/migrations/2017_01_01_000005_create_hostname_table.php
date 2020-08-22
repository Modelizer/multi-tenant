<?php

/*
 * This file is part of the hyn/multi-tenant package.
 *
 * (c) Daniël Klabbers <daniel@klabbers.email>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @see https://laravel-tenancy.com
 * @see https://github.com/hyn/multi-tenant
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHostnameTable extends Migration
{
    public function up()
    {
        Schema::connection('default')
            ->create('hostnames', function (Blueprint $table) {
                $table->bigIncrements('id');

                $table->string('fqdn')->unique();
                $table->string('redirect_to')->nullable();
                $table->boolean('force_https')->default(false);
                $table->timestamp('under_maintenance_since')->nullable();
                $table->bigInteger('partner_id')->unsigned();

                $table->timestamps();
                $table->softDeletes();

                $table->foreign('partner_id')->references('id')->on('partners');
            });
    }

    public function down()
    {
        Schema::dropIfExists('hostnames');
    }
}
