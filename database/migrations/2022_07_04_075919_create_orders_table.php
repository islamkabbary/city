<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('user_addresses_id')->nullable()->constrained('user_addresses')->onDelete('cascade')->onUpdate('cascade');
            $table->enum('status', ['new', 'accept', 'reject', 'cancel', 'done', 'in_way'])->default('new');
            $table->foreignId('added_tax_id')->nullable()->constrained('added_taxes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('delivery_value_id')->nullable()->constrained('delivery_values')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('company_id')->nullable()->constrained('companies')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('promo_code_id')->nullable()->constrained('promo_codes')->onDelete('cascade')->onUpdate('cascade');
            $table->string('phone')->nullable();
            $table->integer('sub_total')->nullable();
            $table->integer('total');
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
        Schema::dropIfExists('orders');
    }
}
