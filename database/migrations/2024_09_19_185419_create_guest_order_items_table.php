<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuestOrderItemsTable extends Migration
{
    public function up()
    {
        Schema::create('guest_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guest_order_id')->constrained('guest_orders')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('price', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('guest_order_items', function (Blueprint $table) {
            $table->dropForeign(['guest_order_id']);
            $table->dropForeign(['product_id']);
        });

        Schema::dropIfExists('guest_order_items');
    }
}
