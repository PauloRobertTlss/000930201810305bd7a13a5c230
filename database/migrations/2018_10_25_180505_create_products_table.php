<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateProductsTable.
 */
class CreateProductsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('products', function(Blueprint $table) {
                    $table->increments('id');
                    $table->integer('category_id')->unsigned()->nullable();
                    $table->foreign('category_id')->references('id')->on('categories');
                    $table->integer('lm')->unsigned();
                    $table->string('name',30);
                    $table->unsignedSmallInteger('free_shipping')->default(0);
                    $table->text('description')->nullable();
                    $table->decimal('price', 9, 2)->default(0);
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
		Schema::drop('products');
	}
}
