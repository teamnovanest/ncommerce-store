<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLenderOfferingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lender_offerings', function (Blueprint $table) {
            $table->id();
            $table->integer('lender_organization_id');
            $table->integer('payment_period');
            $table->integer('percentage');
            $table->unsignedInteger('max_financed')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('lender_offerings');
    }
}
