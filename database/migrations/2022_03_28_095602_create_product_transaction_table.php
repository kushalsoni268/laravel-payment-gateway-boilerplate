<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_transaction', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id')->nullable();
            $table->decimal('amount',15,2)->nullable();
            $table->tinyInteger('payment_type')->comment('1 = Paypal, 2 = Stripe');
            $table->tinyInteger('status')->default('0')->index()->comment('0 = pending, 1 = completed, 2 = failed');
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
        Schema::dropIfExists('product_transaction');
    }
}
