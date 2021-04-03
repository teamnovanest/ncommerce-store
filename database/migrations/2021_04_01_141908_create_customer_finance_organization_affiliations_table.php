<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerFinanceOrganizationAffiliationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_finance_organization_affiliations', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('user_external_reference_id');
            $table->integer('lender_organization_id');
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
        Schema::dropIfExists('customer_finance_organization_affiliations');
    }
}
