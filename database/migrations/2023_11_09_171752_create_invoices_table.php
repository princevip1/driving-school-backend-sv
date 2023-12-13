<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('user');
            $table->string('course');
            $table->string('invoice_number')->unique();
            $table->string('invoice_date');
            $table->string('due_date');
            $table->string('total');
            $table->string('status')->default('unpaid');
            $table->string('payment_method')->nullable();
            $table->string('payment_date')->nullable();
            $table->string('payment_proof')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string("type")->default("student");
            $table->string("route")->nullable();
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
        Schema::dropIfExists('invoices');
    }
};
