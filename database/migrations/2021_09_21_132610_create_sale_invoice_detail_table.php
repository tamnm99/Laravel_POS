<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleInvoiceDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_invoice_detail', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sale_invoice_id');
            $table->bigInteger('product_id');
            $table->decimal('price', 10, 0);
            $table->bigInteger('buying_quantity');
            $table->decimal('discount', 10, 0)->nullable();
            $table->decimal('sub_total', 10, 0);
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
        Schema::dropIfExists('sale_invoice_detail');
    }
}
