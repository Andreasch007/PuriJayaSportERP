<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutgoingInvoicesHTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outgoing_invoices_h', function (Blueprint $table) {
            $table->id();
            $table->string('no_header');
            $table->date('date_header');
            $table->smallInteger('flow_seq');
            $table->smallInteger('doctype_id');
            $table->bigInteger('user_id');
            $table->bigInteger('location_id');
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
        Schema::dropIfExists('outgoing_invoices_h');
    }
}
