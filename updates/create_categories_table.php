<?php namespace Zingabory\Gallery\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateCategoriesTable extends Migration
{

    public function up()
    {
        Schema::create('zingabory_gallery_categories', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->unique();
            $table->mediumText('description')->nullable();
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('zingabory_gal_gal_cat', function($table)
        {
            $table->engine = 'InnoDB';

            $table->integer('gallery_id')->unsigned();
            $table->foreign('gallery_id')->references('id')->on('zingabory_gallery_galleries')->onDelete('cascade');


            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('zingabory_gallery_categories')->onDelete('cascade');

            $table->primary(['gallery_id', 'category_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('zingabory_gallery_categories');
        Schema::dropIfExists('zingabory_gal_gal_cat');
    }

}
