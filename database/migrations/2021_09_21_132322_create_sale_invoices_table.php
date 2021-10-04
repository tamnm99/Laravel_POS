<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_invoices', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->text('code');
            $table->bigInteger('customer_id');
            $table->text('delivery_to');
            $table->decimal('delivery_fee',10,0);
            $table->text('note')->nullable();
            $table->tinyInteger('payment')->comment("1:Tiền Mặt, 2:Chuyển Khoản, 3:Thẻ");
            $table->tinyInteger('status')->comment('1:Đơn Mới, 2:Đang Giao Hàng, 3:Thành Công, 4:Thất Bại');
            $table->bigInteger('tax_id');
            $table->decimal('total_price_product',10,0);
            $table->decimal('tax_fee',10,0);
            $table->decimal('discount_invoice',10,0);
            $table->decimal('total_last',10,0);
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
        Schema::dropIfExists('sale_invoices');
    }
}
