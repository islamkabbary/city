<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->enum('type' , ['admin' , 'company' , 'client' ])->default('client')->nullable();
            $table->boolean('verify_phone')->default(false);
            $table->string('password')->nullable();
            $table->foreignId('city_id')->nullable()->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->text('image')->nullable();
            $table->integer('age')->nullable();
            $table->enum('gender' , ['male' , 'female'])->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
