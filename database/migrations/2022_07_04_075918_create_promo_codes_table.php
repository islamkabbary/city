<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromoCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promo_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade')->onUpdate('cascade');
            $table->enum('type' , ['fixed' , 'percentage'])->nullable();
            $table->unsignedFloat('discount')->nullable();
            $table->unsignedFloat('max_discount')->nullable();
            $table->unsignedInteger('limit_for_user')->nullable();
            $table->unsignedInteger('limit_use')->nullable();
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
        Schema::dropIfExists('promo_codes');
    }
}
