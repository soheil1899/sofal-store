<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('faname');            
            $table->string('enname')->nullable();
            $table->integer('price');
            $table->integer('discount')->default(0);
            $table->boolean('image')->default(false);
            $table->boolean('publish')->default(false);
            $table->boolean('special')->default(false);
            $table->integer('category_id')->unsigned();
            $table->integer('store_id')->unsigned();
            $table->integer('brand_id')->unsigned();
            $table->integer('tedad')->default(0);
            $table->integer('sellcounter')->default(0);
            $table->integer('seencounter')->default(0);
            $table->integer('like')->default(0);
            $table->text('naghd')->nullable();
            $table->timestamps();


            $table->foreign('category_id')->references('id')->on('categories')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('store_id')->references('id')->on('stores')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('brand_id')->references('id')->on('brands')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
