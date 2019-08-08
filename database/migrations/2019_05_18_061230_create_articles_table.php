<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('title');
            $table->string('url');
            $table->text('description')->nullable();
            $table->timestamps();
        });



        Schema::create('articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->integer('user_id')->unsigned();
            $table->boolean('image')->default(false);
            $table->string('url')->nullable();
            $table->text('description')->nullable();
            $table->text('minitext')->nullable();
            $table->boolean('publish')->default(false);
            $table->integer('order')->default(0);
            $table->string('reference')->nullable();
            $table->integer('article_group_id')->unsigned();
            $table->timestamps();

            $table->foreign('article_group_id')->references('id')->on('article_groups')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('cascade');

        });




        Schema::create('article_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type');
            $table->timestamps();

        });

        DB::table('article_types')->insert(
            array(
                'type' => 'عنوان',
                'created_at' => Date::now(),
                'updated_at' => Date::now(),
            )
        );
        DB::table('article_types')->insert(
            array(
                'type' => 'متن',
                'created_at' => Date::now(),
                'updated_at' => Date::now(),
            )
        );
        DB::table('article_types')->insert(
            array(
                'type' => 'گالری تصاویر',
                'created_at' => Date::now(),
                'updated_at' => Date::now(),
            )
        );




        Schema::create('article_contents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('text')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('publish')->default(false);
            $table->integer('article_id')->unsigned();
            $table->integer('article_type_id')->unsigned();
            $table->timestamps();

            $table->foreign('article_id')->references('id')->on('articles')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('article_type_id')->references('id')->on('article_types')
                ->onDelete('cascade')->onUpdate('cascade');
        });



        Schema::create('article_keywords', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('keyword')->nullable();
            $table->integer('article_id')->unsigned()->nullable();
            $table->integer('article_group_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('article_id')->references('id')->on('articles')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('article_group_id')->references('id')->on('article_groups')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article_keywords');
        Schema::dropIfExists('article_contents');
        Schema::dropIfExists('article_types');
        Schema::dropIfExists('articles');
        Schema::dropIfExists('article_groups');
    }
}
