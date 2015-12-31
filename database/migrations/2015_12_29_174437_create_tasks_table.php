<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->string( 'name');
            $table->integer('category_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->date(   'date');
            $table->softDeletes();
            $table->timestamps();

            // a task is owned by the user who created it
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade'); // delete all tasks that belongs to a certain user when this account gets deleted

            // a task must have a valid category
            $table->foreign('category_id')
                  ->references('id')
                  ->on('categories')
                  ->onDelete('cascade'); // delete all tasks that belongs to a certain user when this account gets deleted
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::drop('tasks');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
